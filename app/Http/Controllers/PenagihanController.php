<?php

namespace App\Http\Controllers;

use App\Models\Penagihan;
use App\Models\PenagihanDokumen;
use App\Models\Spk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenagihanController extends Controller implements HasMiddleware
{
    protected string $filePath = 'penagihan';

    protected string $disk = 's3';

    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:penagihan view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:penagihan create', only: ['store', 'init']),
            new Middleware(middleware: 'permission:penagihan edit', only: ['update', 'upload']),
        ];
    }

    public function index(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('dashboard');
        }

        $spkList = Spk::with(['penagihan.dokumen', 'sph'])
            ->where('company_id', $companyId)
            ->orderByDesc('tanggal_spk')
            ->get();

        return view('penagihan.index', compact('spkList'));
    }

    public function show(Spk $spk): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('penagihan.index');
        }

        if ($spk->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }

        $penagihan = $spk->penagihan;

        if (! $penagihan) {
            $penagihan = $this->initPenagihan($spk);
        }

        $penagihan->load(['dokumen.uploader', 'spk.sph']);
        $jenisDokumen = config('penagihan.jenis_dokumen', []);
        $statusList = config('penagihan.status', []);

        return view('penagihan.show', compact('penagihan', 'jenisDokumen', 'statusList'));
    }

    protected function initPenagihan(Spk $spk): Penagihan
    {
        return DB::transaction(function () use ($spk): Penagihan {
            $penagihan = Penagihan::create([
                'company_id' => $spk->company_id,
                'spk_id' => $spk->id,
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            foreach (array_keys(config('penagihan.jenis_dokumen', [])) as $jenis) {
                PenagihanDokumen::create([
                    'penagihan_id' => $penagihan->id,
                    'jenis_dokumen' => $jenis,
                    'is_checked' => false,
                ]);
            }

            return $penagihan->fresh(['dokumen']);
        });
    }

    public function update(Request $request, Penagihan $penagihan): RedirectResponse
    {
        $this->ensureBelongsToCompany($penagihan);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,proses_penagihan,terbayar'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'check' => ['nullable', 'array'],
            'check.*' => ['in:0,1'],
        ]);

        DB::transaction(function () use ($penagihan, $validated): void {
            $penagihan->update([
                'status' => $validated['status'],
                'keterangan' => $validated['keterangan'] ?? null,
                'updated_by' => auth()->id(),
            ]);

            $checks = $validated['check'] ?? [];
            foreach ($penagihan->dokumen as $d) {
                $d->update(['is_checked' => ! empty($checks[$d->id])]);
            }
        });

        Alert::success('Berhasil', 'Proses penagihan berhasil diperbarui.');

        return redirect()->route('penagihan.show', $penagihan->spk);
    }

    public function upload(Request $request, Penagihan $penagihan, string $jenisDokumen): RedirectResponse
    {
        $this->ensureBelongsToCompany($penagihan);

        if (! array_key_exists($jenisDokumen, config('penagihan.jenis_dokumen', []))) {
            Alert::error('Gagal', 'Jenis dokumen tidak valid.');
            return redirect()->route('penagihan.show', $penagihan->spk);
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
        ]);

        $dokumen = $penagihan->dokumen()->where('jenis_dokumen', $jenisDokumen)->firstOrFail();

        if ($dokumen->file_path) {
            Storage::disk($this->disk)->delete($dokumen->file_path);
        }

        $file = $request->file('file');
        $fileName = $file->hashName();
        $path = "{$this->filePath}/{$penagihan->id}";
        Storage::disk($this->disk)->putFileAs($path, $file, $fileName);

        $dokumen->update([
            'file_path' => "{$path}/{$fileName}",
            'file_name' => $file->getClientOriginalName(),
            'uploaded_at' => now(),
            'uploaded_by' => auth()->id(),
            'is_checked' => true,
        ]);

        Alert::success('Berhasil', 'File berhasil diunggah.');

        return redirect()->route('penagihan.show', $penagihan->spk);
    }

    public function download(Penagihan $penagihan, PenagihanDokumen $dokumen): StreamedResponse|RedirectResponse
    {
        $this->ensureBelongsToCompany($penagihan);

        if ($dokumen->penagihan_id !== $penagihan->id || ! $dokumen->file_path) {
            Alert::error('Gagal', 'File tidak ditemukan.');
            return redirect()->route('penagihan.show', $penagihan->spk);
        }

        if (! Storage::disk($this->disk)->exists($dokumen->file_path)) {
            Alert::error('Gagal', 'File tidak ditemukan di storage.');
            return redirect()->route('penagihan.show', $penagihan->spk);
        }

        $downloadName = $dokumen->file_name ?: basename($dokumen->file_path);

        return Storage::disk($this->disk)->download($dokumen->file_path, $downloadName);
    }

    protected function ensureBelongsToCompany(Penagihan $penagihan): void
    {
        $companyId = $this->companyId();
        if ($companyId && $penagihan->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
