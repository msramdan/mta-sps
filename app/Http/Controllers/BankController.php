<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Requests\Banks\{StoreBankRequest, UpdateBankRequest};
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class BankController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // 'auth',

            // TODO: uncomment this code below if you are using spatie permission
            new Middleware(middleware: 'permission:bank view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:bank create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:bank edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:bank delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $banks = Bank::query();

            return DataTables::of(source: $banks)
                ->addColumn(name: 'action', content: 'banks.include.action')
                ->toJson();
        }

        return view(view: 'banks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(view: 'banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request): RedirectResponse
    {

        Bank::create(attributes: $request->validated());

        Alert::success('Berhasil', 'bank berhasil dibuat.');
        return redirect()->route('banks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank): View
    {
        return view(view: 'banks.show', data: compact(var_name: 'bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank): View
    {
        return view(view: 'banks.edit', data: compact(var_name: 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, Bank $bank): RedirectResponse
    {

        $bank->update(attributes: $request->validated());

        Alert::success('Berhasil', 'bank berhasil diperbarui.');
        return redirect()->route('banks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank): RedirectResponse
    {
        try {
            $bank->delete();

            Alert::success('Berhasil', 'bank berhasil dihapus.');
            return redirect()->route('banks.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'bank tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('banks.index');
        }
    }


}
