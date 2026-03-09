<?php

namespace App\Http\Controllers;

use App\Http\Requests\Spk\StoreSpkRequest;
use App\Http\Requests\Spk\UpdateSpkRequest;
use App\Models\Spk;
use App\Models\Sph;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SpkController extends Controller implements HasMiddleware
{
    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:spk view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:spk create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:spk edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:spk delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            if (request()->ajax()) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }

            return view('spk.index');
        }

        if (request()->ajax()) {
            $spk = Spk::with(['sph:id,no_sph', 'creator:id,name'])
                ->where('company_id', $companyId)
                ->orderByDesc('tanggal_spk');

            return DataTables::of($spk)
                ->addColumn('sph_no', fn ($row) => $row->sph?->no_sph ?? '-')
                ->addColumn('creator_name', fn ($row) => $row->creator?->name ?? '-')
                ->addColumn('tanggal_spk_formatted', fn ($row) => $row->tanggal_spk?->format('d/m/Y') ?? '-')
                ->addColumn('tanggal_deadline_formatted', fn ($row) => $row->tanggal_deadline?->format('d/m/Y') ?? '-')
                ->addColumn('nilai_kontrak_formatted', fn ($row) => 'Rp ' . number_format($row->nilai_kontrak, 2, ',', '.'))
                ->addColumn('include_ppn_label', fn ($row) => $row->include_ppn ? 'Ya' : 'Tidak')
                ->addColumn('action', function ($row) {
                    $id = $row->getRawOriginal('id') ?? $row->id;

                    return view('spk.include.action', ['spkId' => $id])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('spk.index');
    }

    public function create(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('spk.index');
        }

        $sphList = Sph::where('company_id', $companyId)
            ->orderByDesc('tanggal_sph')
            ->get(['id', 'no_sph', 'tanggal_sph', 'kunjungan_sale_id']);

        $dateStr = now()->format('Ymd');
        $prefix = "SPK-{$dateStr}-";
        $last = Spk::where('company_id', $companyId)
            ->where('no_spk', 'like', $prefix . '%')
            ->orderByDesc('no_spk')
            ->value('no_spk');
        $next = 1;
        if ($last && preg_match('/' . preg_quote($prefix, '/') . '(\d{3})$/', $last, $m)) {
            $next = (int) $m[1] + 1;
        }
        $generatedNoSpk = $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);

        return view('spk.create', compact('sphList', 'generatedNoSpk'));
    }

    public function store(StoreSpkRequest $request): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('spk.index');
        }

        $validated = $request->safe()->except([]);
        $validated['company_id'] = $companyId;
        $validated['created_by'] = auth()->id();

        Spk::create($validated);

        Alert::success('Berhasil', 'SPK/PO berhasil disimpan.');

        return redirect()->route('spk.index');
    }

    public function show(Spk $spk): View
    {
        $this->ensureBelongsToCompany($spk);
        $spk->load(['sph', 'creator']);

        return view('spk.show', ['spk' => $spk]);
    }

    public function edit(Spk $spk): View|RedirectResponse
    {
        $this->ensureBelongsToCompany($spk);

        $companyId = $this->companyId();
        $sphList = Sph::where('company_id', $companyId)
            ->orderByDesc('tanggal_sph')
            ->get(['id', 'no_sph', 'tanggal_sph']);

        $generatedNoSpk = $spk->no_spk;

        return view('spk.edit', ['spk' => $spk, 'sphList' => $sphList, 'generatedNoSpk' => $generatedNoSpk]);
    }

    public function update(UpdateSpkRequest $request, Spk $spk): RedirectResponse
    {
        $this->ensureBelongsToCompany($spk);

        $spk->update($request->safe()->except([]));

        Alert::success('Berhasil', 'SPK/PO berhasil diperbarui.');

        return redirect()->route('spk.index');
    }

    public function destroy(Spk $spk): RedirectResponse
    {
        $this->ensureBelongsToCompany($spk);

        try {
            $spk->delete();
            Alert::success('Berhasil', 'SPK/PO berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'SPK/PO tidak dapat dihapus.');
        }

        return redirect()->route('spk.index');
    }

    protected function ensureBelongsToCompany(Spk $spk): void
    {
        $companyId = $this->companyId();
        if ($companyId && $spk->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
