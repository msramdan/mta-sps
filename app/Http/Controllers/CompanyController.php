<?php

namespace App\Http\Controllers;

use App\Http\Requests\Companies\StoreCompanyRequest;
use App\Http\Requests\Companies\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:company view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:company create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:company edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:company delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $companies = Company::query()->orderByDesc('created_at');

            return DataTables::of($companies)
                ->addColumn('action', 'companies.include.action')
                ->toJson();
        }

        return view('companies.index');
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            Company::create($request->validated());
        });

        Alert::success('Berhasil', 'Perusahaan berhasil dibuat.');
        return redirect()->route('companies.index');
    }

    public function show(Company $company): View
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        DB::transaction(function () use ($request, $company): void {
            $company->update($request->validated());
        });

        Alert::success('Berhasil', 'Perusahaan berhasil diperbarui.');
        return redirect()->route('companies.index');
    }

    public function destroy(Company $company): RedirectResponse
    {
        try {
            DB::transaction(function () use ($company): void {
                $company->delete();
            });
            Alert::success('Berhasil', 'Perusahaan berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Perusahaan tidak dapat dihapus karena terkait dengan data lain.');
        }

        return redirect()->route('companies.index');
    }
}
