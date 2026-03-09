<?php

namespace App\Http\Controllers;

use App\Http\Requests\Visitors\StoreVisitorRequest;
use App\Http\Requests\Visitors\UpdateVisitorRequest;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller implements HasMiddleware
{
    protected function companyId(): ?string
    {
        return session('session_company_id');
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:visitor view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:visitor create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:visitor edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:visitor delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            if (request()->ajax()) {
                return response()->json(['data' => [], 'recordsTotal' => 0, 'recordsFiltered' => 0]);
            }
            return view('visitors.index');
        }

        if (request()->ajax()) {
            $visitors = Visitor::with(['user:id,name', 'company:id,name'])
                ->where('company_id', $companyId)
                ->select('visitors.*')
                ->orderByDesc('tanggal_visit');

            return DataTables::of($visitors)
                ->addColumn('sales_name', fn ($row) => $row->user?->name ?? '-')
                ->addColumn('tanggal_visit_formatted', fn ($row) => $row->tanggal_visit?->format('d/m/Y') ?? '-')
                ->addColumn('action', function ($row) {
                    $visitorId = $row->getRawOriginal('id') ?? $row->id;
                    return view('visitors.include.action', ['visitorId' => $visitorId])->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('visitors.index');
    }

    public function create(): View|RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('visitors.index');
        }
        return view('visitors.create');
    }

    public function store(StoreVisitorRequest $request): RedirectResponse
    {
        $companyId = $this->companyId();
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('visitors.index');
        }

        DB::transaction(function () use ($request, $companyId): void {
            Visitor::create(array_merge($request->validated(), [
                'company_id' => $companyId,
                'user_id' => auth()->id(),
            ]));
        });

        Alert::success('Berhasil', 'Data kunjungan berhasil disimpan.');
        return redirect()->route('visitors.index');
    }

    public function show(Visitor $visitor): View
    {
        $this->ensureVisitorBelongsToCompany($visitor);
        $visitor->load(['user:id,name', 'company:id,name']);
        return view('visitors.show', compact('visitor'));
    }

    public function edit(Visitor $visitor): View|RedirectResponse
    {
        $this->ensureVisitorBelongsToCompany($visitor);
        return view('visitors.edit', compact('visitor'));
    }

    public function update(UpdateVisitorRequest $request, Visitor $visitor): RedirectResponse
    {
        $this->ensureVisitorBelongsToCompany($visitor);
        $validated = $request->validated();
        unset($validated['user_id']); // User tidak diubah - tetap berdasarkan data awal
        DB::transaction(function () use ($validated, $visitor): void {
            $visitor->update($validated);
        });
        Alert::success('Berhasil', 'Data kunjungan berhasil diperbarui.');
        return redirect()->route('visitors.index');
    }

    public function destroy(Visitor $visitor): RedirectResponse
    {
        $this->ensureVisitorBelongsToCompany($visitor);
        try {
            DB::transaction(fn () => $visitor->delete());
            Alert::success('Berhasil', 'Data kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data tidak dapat dihapus.');
        }
        return redirect()->route('visitors.index');
    }

    protected function ensureVisitorBelongsToCompany(Visitor $visitor): void
    {
        $companyId = $this->companyId();
        if ($companyId && $visitor->company_id !== $companyId) {
            abort(403, 'Akses ditolak.');
        }
    }
}
