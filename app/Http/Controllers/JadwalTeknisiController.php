<?php

namespace App\Http\Controllers;

use App\Models\EstimasiBiayaJadwalTeknisi;
use App\Models\JadwalTeknisi;
use App\Models\Spk;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class JadwalTeknisiController extends Controller implements HasMiddleware
{
    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:jadwal teknisi view', only: ['index', 'show', 'events']),
            new Middleware(middleware: 'permission:jadwal teknisi create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:jadwal teknisi edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:jadwal teknisi delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            if (request()->ajax()) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }

            return view('jadwal-teknisi.index');
        }

        if (request()->ajax()) {
            $jadwal = JadwalTeknisi::with(['creator:id,name', 'teknisi:id,name', 'spk:id,no_spk'])
                ->where('company_id', $companyId)
                ->orderByDesc('tanggal_mulai');

            return DataTables::of($jadwal)
                ->addColumn('spk_no', fn ($row) => $row->spk?->no_spk ?? '-')
                ->addColumn('creator_name', fn ($row) => $row->creator?->name ?? '-')
                ->addColumn('teknisi_names', fn ($row) => $row->teknisi->pluck('name')->implode(', ') ?: '-')
                ->addColumn('tanggal_mulai_formatted', fn ($row) => $row->tanggal_mulai?->format('d/m/Y') ?? '-')
                ->addColumn('tanggal_selesai_formatted', fn ($row) => $row->tanggal_selesai?->format('d/m/Y') ?? '-')
                ->addColumn('total_estimasi', fn ($row) => number_format($row->total_estimasi, 2, ',', '.'))
                ->addColumn('action', function ($row) {
                    $id = $row->getRawOriginal('id') ?? $row->id;
                    return view('jadwal-teknisi.include.action', ['jadwalId' => $id])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('jadwal-teknisi.index');
    }

    public function events(): JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            return response()->json([]);
        }

        $jadwal = JadwalTeknisi::with(['teknisi:id,name', 'spk:id,no_spk'])
            ->where('company_id', $companyId)
            ->orderBy('tanggal_mulai')
            ->get();

        $events = $jadwal->map(function (JadwalTeknisi $j) {
            $end = $j->tanggal_selesai ?? $j->tanggal_mulai;
            $title = $j->judul ?: 'Jadwal';
            $teknisis = $j->teknisi->pluck('name')->implode(', ');
            if ($teknisis) {
                $title .= ' — ' . $teknisis;
            }
            $endExclusive = $end->copy()->addDay()->format('Y-m-d');

            return [
                'id' => $j->id,
                'title' => $title,
                'start' => $j->tanggal_mulai->format('Y-m-d'),
                'end' => $endExclusive,
                'url' => route('jadwal-teknisi.show', $j->id),
                'extendedProps' => [
                    'judul' => $j->judul ?: '-',
                    'spk_no' => $j->spk?->no_spk ?: '-',
                    'tanggal_mulai' => $j->tanggal_mulai->format('d/m/Y'),
                    'tanggal_selesai' => $j->tanggal_selesai?->format('d/m/Y') ?? '-',
                    'teknisi' => $teknisis ?: '-',
                    'total_estimasi' => number_format($j->total_estimasi, 2, ',', '.'),
                    'keterangan' => $j->keterangan ?: '-',
                ],
            ];
        });

        return response()->json($events);
    }

    public function create(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('jadwal-teknisi.index');
        }

        $teknisi = User::role('Teknisi')
            ->orderBy('name')
            ->get(['id', 'name']);

        $spkList = Spk::where('company_id', $companyId)
            ->orderByDesc('tanggal_spk')
            ->get(['id', 'no_spk', 'tanggal_spk', 'sph_id']);

        return view('jadwal-teknisi.create', compact('teknisi', 'spkList'));
    }

    public function store(): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('jadwal-teknisi.index');
        }

        request()->merge(['spk_id' => request()->input('spk_id') ?: null]);
        $validated = request()->validate([
            'spk_id' => ['nullable', 'exists:spk,id'],
            'judul' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan' => ['nullable', 'string'],
            'teknisi_ids' => ['required', 'array'],
            'teknisi_ids.*' => ['exists:users,id'],
            'biaya' => ['nullable', 'array'],
            'biaya.*.keterangan_biaya' => ['nullable', 'string', 'max:255'],
            'biaya.*.estimasi_total' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $companyId): void {
            $jadwal = JadwalTeknisi::create([
                'company_id' => $companyId,
                'spk_id' => $validated['spk_id'] ?? null,
                'judul' => $validated['judul'] ?? null,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
                'keterangan' => $validated['keterangan'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Filter teknisi benar-benar ber-role Teknisi
            $teknisiValid = User::role('Teknisi')
                ->whereIn('id', $validated['teknisi_ids'] ?? [])
                ->pluck('id')
                ->all();
            $jadwal->teknisi()->sync($teknisiValid);

            foreach ($validated['biaya'] ?? [] as $row) {
                $ket = $row['keterangan_biaya'] ?? null;
                $total = $row['estimasi_total'] ?? null;
                if (! $ket && $total === null) {
                    continue;
                }

                EstimasiBiayaJadwalTeknisi::create([
                    'jadwal_teknisi_id' => $jadwal->id,
                    'keterangan_biaya' => $ket,
                    'estimasi_total' => $total ?? 0,
                    'created_at' => now(),
                ]);
            }
        });

        Alert::success('Berhasil', 'Jadwal teknisi berhasil dibuat.');
        return redirect()->route('jadwal-teknisi.index');
    }

    public function show(JadwalTeknisi $jadwal_teknisi): View
    {
        $this->ensureBelongsToCompany($jadwal_teknisi);
        $jadwal_teknisi->load(['creator:id,name', 'teknisi:id,name', 'estimasiBiaya', 'spk:id,no_spk']);

        return view('jadwal-teknisi.show', ['jadwal' => $jadwal_teknisi]);
    }

    public function edit(JadwalTeknisi $jadwal_teknisi): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('jadwal-teknisi.index');
        }

        $this->ensureBelongsToCompany($jadwal_teknisi);

        $teknisi = User::role('Teknisi')
            ->orderBy('name')
            ->get(['id', 'name']);

        $spkList = Spk::where('company_id', $companyId)
            ->orderByDesc('tanggal_spk')
            ->get(['id', 'no_spk', 'tanggal_spk']);

        $jadwal_teknisi->load(['teknisi:id']);

        return view('jadwal-teknisi.edit', [
            'jadwal' => $jadwal_teknisi,
            'teknisi' => $teknisi,
            'spkList' => $spkList,
        ]);
    }

    public function update(JadwalTeknisi $jadwal_teknisi): RedirectResponse
    {
        $this->ensureBelongsToCompany($jadwal_teknisi);

        request()->merge(['spk_id' => request()->input('spk_id') ?: null]);
        $validated = request()->validate([
            'spk_id' => ['nullable', 'exists:spk,id'],
            'judul' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'keterangan' => ['nullable', 'string'],
            'teknisi_ids' => ['required', 'array'],
            'teknisi_ids.*' => ['exists:users,id'],
            'biaya' => ['nullable', 'array'],
            'biaya.*.keterangan_biaya' => ['nullable', 'string', 'max:255'],
            'biaya.*.estimasi_total' => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $jadwal_teknisi): void {
            $jadwal_teknisi->update([
                'spk_id' => $validated['spk_id'] ?? null,
                'judul' => $validated['judul'] ?? null,
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            $teknisiValid = User::role('Teknisi')
                ->whereIn('id', $validated['teknisi_ids'] ?? [])
                ->pluck('id')
                ->all();
            $jadwal_teknisi->teknisi()->sync($teknisiValid);

            // Reset estimasi biaya dan isi ulang
            $jadwal_teknisi->estimasiBiaya()->delete();
            foreach ($validated['biaya'] ?? [] as $row) {
                $ket = $row['keterangan_biaya'] ?? null;
                $total = $row['estimasi_total'] ?? null;
                if (! $ket && $total === null) {
                    continue;
                }

                EstimasiBiayaJadwalTeknisi::create([
                    'jadwal_teknisi_id' => $jadwal_teknisi->id,
                    'keterangan_biaya' => $ket,
                    'estimasi_total' => $total ?? 0,
                    'created_at' => now(),
                ]);
            }
        });

        Alert::success('Berhasil', 'Jadwal teknisi berhasil diperbarui.');
        return redirect()->route('jadwal-teknisi.index');
    }

    public function destroy(JadwalTeknisi $jadwal_teknisi): RedirectResponse
    {
        $this->ensureBelongsToCompany($jadwal_teknisi);

        try {
            DB::transaction(function () use ($jadwal_teknisi): void {
                $jadwal_teknisi->estimasiBiaya()->delete();
                $jadwal_teknisi->teknisi()->detach();
                $jadwal_teknisi->delete();
            });

            Alert::success('Berhasil', 'Jadwal teknisi berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Jadwal teknisi tidak dapat dihapus.');
        }

        return redirect()->route('jadwal-teknisi.index');
    }

    protected function ensureBelongsToCompany(JadwalTeknisi $jadwal): void
    {
        $companyId = $this->companyId();
        if ($companyId && $jadwal->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}

