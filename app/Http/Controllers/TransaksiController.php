<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaksis\StoreTransaksiRequest;
use App\Http\Requests\Transaksis\UpdateTransaksiRequest;
use App\Models\Transaksi;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            new Middleware(middleware: 'permission:transaksi view', only: ['index', 'show', 'summary']),
            new Middleware(middleware: 'permission:transaksi create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:transaksi edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:transaksi delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
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

            // Filter tanggal
            if ($request->filled('tanggal_from')) {
                $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_from);
            }
            if ($request->filled('tanggal_to')) {
                $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_to);
            }
            // Filter status
            if ($request->filled('status') && $request->status !== '') {
                $query->where('status', $request->status);
            }

            $transaksis = $query->latest();

            return DataTables::of($transaksis)
                ->addColumn('action', 'transaksis.include.action')
                ->editColumn('no_ref_merchant', function ($transaksi) {
                    return $transaksi->no_ref_merchant ?? '-';
                })
                ->editColumn('merchant_id', function ($transaksi) {
                    return $transaksi->merchant?->nama_merchant ?? '-';
                })
                ->editColumn('beban_biaya', function ($transaksi) {
                    $val = $transaksi->beban_biaya ?? 'Merchant';
                    $badge = $val === 'Pelanggan' ? 'bg-secondary' : 'bg-info';
                    return '<span class="badge ' . $badge . '">' . e($val) . '</span>';
                })
                ->editColumn('biaya', function ($transaksi) {
                    return 'Rp ' . number_format($transaksi->biaya, 0, ',', '.');
                })
                ->editColumn('jumlah_dibayar', function ($transaksi) {
                    return 'Rp ' . number_format($transaksi->jumlah_dibayar, 0, ',', '.');
                })
                ->editColumn('jumlah_diterima', function ($transaksi) {
                    return 'Rp ' . number_format($transaksi->jumlah_diterima ?? 0, 0, ',', '.');
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
                ->rawColumns(['action', 'status', 'beban_biaya'])
                ->make(true);
        }

        $summary = null;
        $filterDefaults = (object) [
            'tanggal_from' => $request->get('tanggal_from', now()->startOfMonth()->format('Y-m-d')),
            'tanggal_to' => $request->get('tanggal_to', now()->format('Y-m-d')),
            'status' => $request->get('status', ''),
        ];
        $merchantId = session('sessionMerchant');
        if ($merchantId) {
            $merchant = Merchant::find($merchantId);
            if ($merchant) {
                $tanggalFrom = $filterDefaults->tanggal_from;
                $tanggalTo = $filterDefaults->tanggal_to;
                $statusFilter = $filterDefaults->status;

                $q = Transaksi::where('merchant_id', $merchantId)
                    ->whereDate('tanggal_transaksi', '>=', $tanggalFrom)
                    ->whereDate('tanggal_transaksi', '<=', $tanggalTo);
                if ($statusFilter !== '') {
                    $q->where('status', $statusFilter);
                }

                $totalTransaksi = (clone $q)->count();
                $totalSuccess = (clone $q)->where('status', 'success')->count();
                $totalDibayar = (float) (clone $q)->where('status', 'success')->sum('jumlah_dibayar');
                $totalBiaya = (float) (clone $q)->where('status', 'success')->sum('biaya');

                $summary = (object) [
                    'nama_merchant' => $merchant->nama_merchant,
                    'tanggal_from' => $tanggalFrom,
                    'tanggal_to' => $tanggalTo,
                    'total_transaksi' => $totalTransaksi,
                    'total_success' => $totalSuccess,
                    'total_dibayar' => $totalDibayar,
                    'total_biaya' => $totalBiaya,
                ];
            }
        }

        return view('transaksis.index', compact('summary', 'filterDefaults'));
    }

    /**
     * Get summary for filtered transaksi (AJAX).
     */
    public function summary(Request $request): JsonResponse
    {
        $merchantId = session('sessionMerchant');
        if (!$merchantId) {
            return response()->json(['error' => 'Merchant tidak ditemukan'], 404);
        }

        $tanggalFrom = $request->get('tanggal_from', now()->startOfMonth()->format('Y-m-d'));
        $tanggalTo = $request->get('tanggal_to', now()->format('Y-m-d'));
        $statusFilter = $request->get('status', '');

        $q = Transaksi::where('merchant_id', $merchantId)
            ->whereDate('tanggal_transaksi', '>=', $tanggalFrom)
            ->whereDate('tanggal_transaksi', '<=', $tanggalTo);
        if ($statusFilter !== '') {
            $q->where('status', $statusFilter);
        }

        $totalTransaksi = (clone $q)->count();
        $totalSuccess = (clone $q)->where('status', 'success')->count();
        $totalDibayar = (float) (clone $q)->where('status', 'success')->sum('jumlah_dibayar');
        $totalBiaya = (float) (clone $q)->where('status', 'success')->sum('biaya');

        return response()->json([
            'total_transaksi' => $totalTransaksi,
            'total_success' => $totalSuccess,
            'total_dibayar' => $totalDibayar,
            'total_biaya' => $totalBiaya,
        ]);
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
        $bebanBiaya = $validated['beban_biaya'];

        if ($bebanBiaya === 'Merchant') {
            $jumlahDibayar = (float) ($validated['jumlah_dibayar'] ?? 0);
            $hitung = Transaksi::hitungBiayaDanDiterima($jumlahDibayar);
            $validated['biaya'] = $hitung['biaya'];
            $validated['jumlah_diterima'] = $hitung['jumlah_diterima'];
        } else {
            $jumlahDiterima = (float) ($validated['jumlah_diterima'] ?? 0);
            $hitung = Transaksi::hitungDariJumlahDiterima($jumlahDiterima);
            $validated['jumlah_dibayar'] = $hitung['jumlah_dibayar'];
            $validated['biaya'] = $hitung['biaya'];
            $validated['jumlah_diterima'] = $hitung['jumlah_diterima'];
        }

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
            'logGenerateQrs' => fn ($q) => $q->orderByDesc('created_at'),
            'logCallbacks' => fn ($q) => $q->orderByDesc('tanggal_callback_nobu_to_qrin')->orderByDesc('created_at'),
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

        $bebanBiaya = $validated['beban_biaya'];
        if ($bebanBiaya === 'Merchant') {
            $jumlahDibayar = (float) ($validated['jumlah_dibayar'] ?? 0);
            $hitung = Transaksi::hitungBiayaDanDiterima($jumlahDibayar);
            $validated['biaya'] = $hitung['biaya'];
            $validated['jumlah_diterima'] = $hitung['jumlah_diterima'];
        } else {
            $jumlahDiterima = (float) ($validated['jumlah_diterima'] ?? 0);
            $hitung = Transaksi::hitungDariJumlahDiterima($jumlahDiterima);
            $validated['jumlah_dibayar'] = $hitung['jumlah_dibayar'];
            $validated['biaya'] = $hitung['biaya'];
            $validated['jumlah_diterima'] = $hitung['jumlah_diterima'];
        }

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
