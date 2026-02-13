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
            $transaksis = Transaksi::with('merchant:id,nama_merchant,kode_merchant')->latest();

            return DataTables::of($transaksis)
                ->addColumn('action', function ($transaksi) {
                    $showBtn = '<a href="' . route('transaksis.show', $transaksi->id) . '" class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('transaksis.edit', $transaksi->id) . '" class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>';
                    $deleteBtn = '<form action="' . route('transaksis.destroy', $transaksi->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus?\')"><i class="fas fa-trash"></i></button>
                    </form>';

                    return $showBtn . $editBtn . $deleteBtn;
                })
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
        $merchants = Merchant::where('status', 'approved')->get(['id', 'nama_merchant', 'kode_merchant']);

        return view('transaksis.create', compact('merchants'));
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
        $transaksi->load('merchant:id,nama_merchant,kode_merchant');

        return view('transaksis.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi): View
    {
        $merchants = Merchant::where('status', 'approved')->get(['id', 'nama_merchant', 'kode_merchant']);

        return view('transaksis.edit', compact('transaksi', 'merchants'));
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
