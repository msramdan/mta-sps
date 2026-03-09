<?php

namespace App\Http\Controllers;

use App\Models\JadwalTeknisi;
use App\Models\WorkingProgress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;

class WorkingController extends Controller implements HasMiddleware
{
    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:working view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:working create', only: ['store']),
        ];
    }

    public function index(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('dashboard');
        }

        $jadwalList = JadwalTeknisi::with(['spk:id,no_spk,jumlah_alat', 'teknisi:id,name'])
            ->where('company_id', $companyId)
            ->whereHas('spk')
            ->withSum('workingProgress', 'jumlah_selesai')
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('working.index', compact('jadwalList'));
    }

    public function show(JadwalTeknisi $jadwal_teknisi): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('working.index');
        }

        $this->ensureBelongsToCompany($jadwal_teknisi);

        $jadwal_teknisi->load(['spk', 'teknisi:id,name', 'workingProgress.creator:id,name']);

        if (! $jadwal_teknisi->spk) {
            Alert::warning('Peringatan', 'Jadwal ini belum terkait SPK/PO. Lampirkan SPK terlebih dahulu untuk input progress.');
            return redirect()->route('working.index');
        }

        $canInput = auth()->user()->can('working create');

        return view('working.show', [
            'jadwal' => $jadwal_teknisi,
            'canInput' => $canInput,
        ]);
    }

    public function store(JadwalTeknisi $jadwal_teknisi): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('working.index');
        }

        $this->ensureBelongsToCompany($jadwal_teknisi);

        if (! $jadwal_teknisi->spk) {
            Alert::warning('Peringatan', 'Jadwal ini belum terkait SPK/PO.');
            return redirect()->route('working.index');
        }

        $validated = request()->validate([
            'tanggal' => ['required', 'date'],
            'jumlah_selesai' => ['required', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $totalAlat = $jadwal_teknisi->spk->jumlah_alat;
        $sudahSelesai = $jadwal_teknisi->workingProgress()->sum('jumlah_selesai');
        $setelahInput = $sudahSelesai + $validated['jumlah_selesai'];

        if ($setelahInput > $totalAlat) {
            Alert::warning('Peringatan', "Jumlah melebihi target. Total alat: {$totalAlat}, sudah selesai: {$sudahSelesai}.");
            return redirect()->route('working.show', $jadwal_teknisi);
        }

        WorkingProgress::create([
            'jadwal_teknisi_id' => $jadwal_teknisi->id,
            'tanggal' => $validated['tanggal'],
            'jumlah_selesai' => $validated['jumlah_selesai'],
            'keterangan' => $validated['keterangan'] ?? null,
            'created_by' => auth()->id(),
        ]);

        Alert::success('Berhasil', 'Progress pekerjaan berhasil ditambahkan.');

        return redirect()->route('working.show', $jadwal_teknisi);
    }

    protected function ensureBelongsToCompany(JadwalTeknisi $jadwal): void
    {
        $companyId = $this->companyId();
        if ($companyId && $jadwal->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
