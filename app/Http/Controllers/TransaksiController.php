<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaksis\StoreTransaksiRequest;
use App\Http\Requests\Transaksis\UpdateTransaksiRequest;
use App\Models\Transaksi;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller implements HasMiddleware
{
    /**
     * Get middleware for controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:transaksi view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:transaksi create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:transaksi edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:transaksi delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $query = Transaksi::with('merchant:id,nama_merchant,kode_merchant');

            // Filter by session merchant - no data if no session
            $merchantId = session('sessionMerchant');
            if ($merchantId) {
                $query->where('merchant_id', $merchantId);
            } else {
                $query->whereRaw('1 = 0'); // Return empty if no merchant session
            }

            $transaksis = $query->latest();

            return DataTables::of($transaksis)
                ->addIndexColumn()
                ->addColumn('action', 'transaksis.include.action')
                ->editColumn('no_ref_merchant', function ($transaksi) {
                    return $transaksi->no_ref_merchant ?? '-';
                })
                ->editColumn('merchant_id', function ($transaksi) {
                    return $transaksi->merchant?->nama_merchant ?? '-';
                })
                ->editColumn('biaya', function ($transaksi) {
                    return 'Rp ' . number_format($transaksi->biaya, 0, ',', '.');
                })
                ->editColumn('jumlah_dibayar', function ($transaksi) {
                    return 'Rp ' . number_format($transaksi->jumlah_dibayar, 0, ',', '.');
                })
                ->editColumn('status', function ($transaksi) {
                    $badges = [
                        'pending' => '<span class="badge bg-warning">Pending</span>',
                        'success' => '<span class="badge bg-success">Success</span>',
                        'failed' => '<span class="badge bg-danger">Failed</span>',
                        'expired' => '<span class="badge bg-secondary">Expired</span>',
                    ];
                    return $badges[$transaksi->status] ?? '<span class="badge bg-light text-dark">Unknown</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('transaksis.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('transaksis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaksiRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Transaksi::create($validated);

        Alert::success('Berhasil', 'Transaksi berhasil dibuat.');
        return redirect()->route('transaksis.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi): View
    {
        $transaksi->load([
            'merchant:id,nama_merchant,kode_merchant',
            'logGenerateQrs' => fn ($q) => $q->orderBy('created_at'),
            'logCallbacks' => fn ($q) => $q->orderBy('tanggal_callback')->orderBy('created_at'),
        ]);

        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi): View
    {
        $transaksi->load('merchant:id,nama_merchant,kode_merchant');

        return view('transaksis.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaksiRequest $request, Transaksi $transaksi): RedirectResponse
    {
        $validated = $request->validated();

        // Exclude no_referensi from update (should never be updated)
        unset($validated['no_referensi']);

        $transaksi->update($validated);

        Alert::success('Berhasil', 'Transaksi berhasil diperbarui.');
        return redirect()->route('transaksis.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi): RedirectResponse
    {
        $transaksi->delete();

        Alert::success('Berhasil', 'Transaksi berhasil dihapus.');
        return redirect()->route('transaksis.index');
    }
}
