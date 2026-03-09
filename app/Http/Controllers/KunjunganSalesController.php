<?php

namespace App\Http\Controllers;

use App\Generators\Services\ImageServiceV2;
use App\Http\Requests\KunjunganSales\StoreKunjunganSalesRequest;
use App\Http\Requests\KunjunganSales\UpdateKunjunganSalesRequest;
use App\Models\KunjunganSale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KunjunganSalesController extends Controller implements HasMiddleware
{
    public function __construct(
        protected ImageServiceV2 $imageService,
        protected string $evidencePath = 'kunjungan_sales',
        protected string $disk = 's3'
    ) {}

    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:kunjungan sales view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:kunjungan sales create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:kunjungan sales edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:kunjungan sales delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            if (request()->ajax()) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }
            return view('kunjungan-sales.index');
        }

        if (request()->ajax()) {
            $kunjungan = KunjunganSale::with(['user:id,name', 'company:id,name'])
                ->where('company_id', $companyId)
                ->select('kunjungan_sales.*')
                ->orderByDesc('tanggal_visit');

            return DataTables::of($kunjungan)
                ->addColumn('sales_name', fn ($row) => $row->user?->name ?? '-')
                ->addColumn('tanggal_visit_formatted', fn ($row) => $row->tanggal_visit?->format('d/m/Y') ?? '-')
                ->addColumn('action', function ($row) {
                    $id = $row->getRawOriginal('id') ?? $row->id;
                    return view('kunjungan-sales.include.action', ['kunjunganSaleId' => $id])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('kunjungan-sales.index');
    }

    public function create(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('kunjungan-sales.index');
        }
        return view('kunjungan-sales.create');
    }

    public function store(StoreKunjunganSalesRequest $request): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('kunjungan-sales.index');
        }

        DB::transaction(function () use ($request, $companyId): void {
            $validated = $request->validated();
            $validated['evidence'] = $this->imageService->upload(
                name: 'evidence',
                path: $this->evidencePath,
                defaultImage: null,
                disk: $this->disk
            );
            $validated['company_id'] = $companyId;
            $validated['user_id'] = auth()->id();

            KunjunganSale::create($validated);
        });

        Alert::success('Berhasil', 'Data kunjungan berhasil disimpan.');
        return redirect()->route('kunjungan-sales.index');
    }

    public function show(KunjunganSale $kunjungan_sale): View
    {
        $this->ensureBelongsToCompany($kunjungan_sale);
        $kunjungan_sale->load(['user:id,name', 'company:id,name']);
        return view('kunjungan-sales.show', compact('kunjungan_sale'));
    }

    public function edit(KunjunganSale $kunjungan_sale): View|RedirectResponse
    {
        $this->ensureBelongsToCompany($kunjungan_sale);
        return view('kunjungan-sales.edit', compact('kunjungan_sale'));
    }

    public function update(UpdateKunjunganSalesRequest $request, KunjunganSale $kunjungan_sale): RedirectResponse
    {
        $this->ensureBelongsToCompany($kunjungan_sale);
        $validated = $request->validated();
        unset($validated['user_id']);
        $oldEvidence = null;
        if ($request->hasFile('evidence') && $request->file('evidence')->isValid()) {
            $oldEvidence = $kunjungan_sale->getRawOriginal('evidence');
            $validated['evidence'] = $this->imageService->upload(
                name: 'evidence',
                path: $this->evidencePath,
                defaultImage: null,
                disk: $this->disk
            );
        } else {
            unset($validated['evidence']);
        }
        DB::transaction(function () use ($validated, $kunjungan_sale): void {
            $kunjungan_sale->update($validated);
        });
        if ($oldEvidence) {
            $this->imageService->delete(
                path: $this->evidencePath,
                image: $oldEvidence,
                disk: $this->disk
            );
        }
        Alert::success('Berhasil', 'Data kunjungan berhasil diperbarui.');
        return redirect()->route('kunjungan-sales.index');
    }

    public function destroy(KunjunganSale $kunjungan_sale): RedirectResponse
    {
        $this->ensureBelongsToCompany($kunjungan_sale);
        try {
            DB::transaction(fn () => $kunjungan_sale->delete());
            Alert::success('Berhasil', 'Data kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data tidak dapat dihapus.');
        }
        return redirect()->route('kunjungan-sales.index');
    }

    protected function ensureBelongsToCompany(KunjunganSale $kunjungan_sale): void
    {
        $companyId = $this->companyId();
        if ($companyId && $kunjungan_sale->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
