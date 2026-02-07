<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\Produks\{StoreProdukRequest, UpdateProdukRequest};
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class ProdukController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // 'auth',

            // TODO: uncomment this code below if you are using spatie permission
            // new Middleware(middleware: 'permission:produk view', only: ['index', 'show']),
            // new Middleware(middleware: 'permission:produk create', only: ['create', 'store']),
            // new Middleware(middleware: 'permission:produk edit', only: ['edit', 'update']),
            // new Middleware(middleware: 'permission:produk delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $produks = Produk::query();

            return DataTables::of(source: $produks)
                ->addColumn(name: 'action', content: 'produks.include.action')
                ->toJson();
        }

        return view(view: 'produks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(view: 'produks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request): RedirectResponse
    {
        
        Produk::create(attributes: $request->validated());

        Alert::success('Berhasil', 'produk berhasil dibuat.');
        return redirect()->route('produks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk): View
    {
        return view(view: 'produks.show', data: compact(var_name: 'produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk): View
    {
        return view(view: 'produks.edit', data: compact(var_name: 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $produk): RedirectResponse
    {
        
        $produk->update(attributes: $request->validated());

        Alert::success('Berhasil', 'produk berhasil diperbarui.');
        return redirect()->route('produks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk): RedirectResponse
    {
        try {
            $produk->delete();

            Alert::success('Berhasil', 'produk berhasil dihapus.');
            return redirect()->route('produks.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'produk tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('produks.index');
        }
    }

    
}
