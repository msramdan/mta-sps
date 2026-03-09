<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sph\StoreSphRequest;
use App\Http\Requests\Sph\StoreSphRevisionRequest;
use App\Models\Sph;
use App\Models\SphDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SphController extends Controller implements HasMiddleware
{
    protected string $filePath = 'sph';

    protected string $disk = 's3';

    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:sph view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:sph create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:sph edit', only: ['revision', 'storeRevision']),
            new Middleware(middleware: 'permission:sph delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            if (request()->ajax()) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }
            return view('sph.index');
        }

        if (request()->ajax()) {
            $sph = Sph::with(['user:id,name', 'company:id,name'])
                ->withMax('details', 'version')
                ->where('company_id', $companyId)
                ->orderByDesc('tanggal_sph');

            return DataTables::of($sph)
                ->addColumn('sales_name', fn ($row) => $row->user?->name ?? '-')
                ->addColumn('tanggal_sph_formatted', fn ($row) => $row->tanggal_sph?->format('d/m/Y') ?? '-')
                ->addColumn('latest_version', fn ($row) => $row->details_max_version ?? '-')
                ->addColumn('action', function ($row) {
                    $id = $row->getRawOriginal('id') ?? $row->id;
                    return view('sph.include.action', ['sphId' => $id])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('sph.index');
    }

    public function create(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('sph.index');
        }
        $kunjunganSales = \App\Models\KunjunganSale::where('company_id', $companyId)
            ->orderByDesc('tanggal_visit')
            ->get(['id', 'nama_rs', 'tanggal_visit', 'user_id']);

        $dateStr = now()->format('Ymd');
        $prefix = "SPH-{$dateStr}-";
        $last = Sph::where('company_id', $companyId)
            ->where('no_sph', 'like', $prefix . '%')
            ->orderByDesc('no_sph')
            ->value('no_sph');
        $next = 1;
        if ($last && preg_match('/' . preg_quote($prefix, '/') . '(\d{3})$/', $last, $m)) {
            $next = (int) $m[1] + 1;
        }
        $generatedNoSph = $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        return view('sph.create', compact('kunjunganSales', 'generatedNoSph'));
    }

    public function store(StoreSphRequest $request): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('sph.index');
        }

        DB::transaction(function () use ($request, $companyId): void {
            $validated = $request->safe()->except(['file', 'catatan_revisi']);
            $validated['company_id'] = $companyId;
            $validated['user_id'] = auth()->id();
            $validated['created_by'] = auth()->id();

            $sph = Sph::create($validated);

            $fileName = null;
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $fileName = $request->file('file')->hashName();
                Storage::disk($this->disk)->putFileAs($this->filePath, $request->file('file'), $fileName);
            }

            SphDetail::create([
                'sph_id' => $sph->id,
                'version' => 1,
                'file_path' => $fileName,
                'catatan_revisi' => $request->validated('catatan_revisi'),
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
        });

        Alert::success('Berhasil', 'SPH berhasil disimpan.');
        return redirect()->route('sph.index');
    }

    public function show(Sph $sph): View
    {
        $this->ensureBelongsToCompany($sph);
        $sph->load(['user:id,name', 'kunjunganSale:id,nama_rs', 'details.creator:id,name']);

        return view('sph.show', compact('sph'));
    }

    public function destroy(Sph $sph): RedirectResponse
    {
        $this->ensureBelongsToCompany($sph);
        try {
            $filePaths = $sph->details()->whereNotNull('file_path')->pluck('file_path');
            DB::transaction(fn () => $sph->delete());
            foreach ($filePaths as $fp) {
                Storage::disk($this->disk)->delete("$this->filePath/$fp");
            }
            Alert::success('Berhasil', 'SPH berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'SPH tidak dapat dihapus.');
        }

        return redirect()->route('sph.index');
    }

    public function revision(Sph $sph): View|RedirectResponse
    {
        $this->ensureBelongsToCompany($sph);
        $companyId = $this->companyId();
        $kunjunganSales = \App\Models\KunjunganSale::where('company_id', $companyId)
            ->orderByDesc('tanggal_visit')
            ->get(['id', 'nama_rs', 'tanggal_visit', 'user_id']);

        return view('sph.revision', compact('sph', 'kunjunganSales'));
    }

    public function storeRevision(StoreSphRevisionRequest $request, Sph $sph): RedirectResponse
    {
        $this->ensureBelongsToCompany($sph);

        $headerData = $request->safe()->only(['tanggal_sph', 'kunjungan_sale_id', 'keterangan']);
        $sph->update($headerData);

        $hasFile = $request->hasFile('file') && $request->file('file')->isValid();
        $hasCatatan = filled($request->validated('catatan_revisi'));

        if ($hasFile || $hasCatatan) {
            $latest = $sph->latestDetail();
            $nextVersion = $latest ? $latest->version + 1 : 1;

            $filePath = null;
            if ($hasFile) {
                $filePath = $request->file('file')->hashName();
                Storage::disk($this->disk)->putFileAs($this->filePath, $request->file('file'), $filePath);
            } elseif ($latest?->file_path) {
                $filePath = $latest->file_path;
            }

            SphDetail::create([
                'sph_id' => $sph->id,
                'version' => $nextVersion,
                'file_path' => $filePath,
                'catatan_revisi' => $request->validated('catatan_revisi'),
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
            Alert::success('Berhasil', 'Data diperbarui. Revisi v' . $nextVersion . ' berhasil disimpan.');
        } else {
            Alert::success('Berhasil', 'Data SPH berhasil diperbarui.');
        }

        return redirect()->route('sph.show', $sph);
    }

    public function downloadDetail(Sph $sph, SphDetail $detail): StreamedResponse|RedirectResponse
    {
        $this->ensureBelongsToCompany($sph);
        if ($detail->sph_id !== $sph->id) {
            abort(404);
        }
        if (! $detail->file_path) {
            Alert::warning('Tidak ada file', 'Versi ini tidak memiliki file attachment.');
            return redirect()->route('sph.show', $sph);
        }

        $fullPath = "{$this->filePath}/{$detail->file_path}";
        if (! Storage::disk($this->disk)->exists($fullPath)) {
            Alert::error('File tidak ditemukan');
            return redirect()->route('sph.show', $sph);
        }

        $detail->increment('total_download');

        $ext = pathinfo($detail->file_path, PATHINFO_EXTENSION) ?: 'pdf';
        $filename = "SPH-v{$detail->version}.{$ext}";
        $mime = match (strtolower($ext)) {
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
        try {
            $mime = Storage::disk($this->disk)->mimeType($fullPath) ?: $mime;
        } catch (\Throwable) {
            // keep fallback mime
        }
        $disk = $this->disk;
        return response()->streamDownload(
            function () use ($fullPath, $disk) {
                echo Storage::disk($disk)->get($fullPath);
            },
            $filename,
            ['Content-Type' => $mime, 'Content-Disposition' => 'attachment; filename="' . $filename . '"']
        );
    }

    protected function ensureBelongsToCompany(Sph $sph): void
    {
        $companyId = $this->companyId();
        if ($companyId && $sph->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
