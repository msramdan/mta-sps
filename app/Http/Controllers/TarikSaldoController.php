<?php

namespace App\Http\Controllers;

use App\Models\TarikSaldo;
use App\Http\Requests\TarikSaldos\{StoreTarikSaldoRequest, UpdateTarikSaldoRequest};
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class TarikSaldoController extends Controller implements HasMiddleware
{
    public function __construct(public ImageServiceV2 $imageServiceV2, public string $buktiTrfPath = 'bukti-trves', public string $disk = 'public')
    {
        //
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            // 'auth',

            // TODO: uncomment this code below if you are using spatie permission
            // new Middleware(middleware: 'permission:tarik saldo view', only: ['index', 'show']),
            // new Middleware(middleware: 'permission:tarik saldo create', only: ['create', 'store']),
            // new Middleware(middleware: 'permission:tarik saldo edit', only: ['edit', 'update']),
            // new Middleware(middleware: 'permission:tarik saldo delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $query = TarikSaldo::with(relations: ['merchant:id,nama_merchant', 'bank:id,nama_bank']);

            // Filter by session merchant - no data if no session
            $merchantId = session('sessionMerchant');
            if ($merchantId) {
                $query->where('merchant_id', $merchantId);
            } else {
                $query->whereRaw('1 = 0'); // Return empty if no merchant session
            }

            return Datatables::of(source: $query)
                ->addColumn(name: 'merchant', content: fn($row): ?string => $row?->merchant?->nama_merchant ?? '')
				->addColumn(name: 'bank', content: fn($row): ?string => $row?->bank?->nama_bank ?? '')

                ->addColumn(name: 'action', content: 'tarik-saldos.include.action')
                ->toJson();
        }

        return view(view: 'tarik-saldos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(view: 'tarik-saldos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTarikSaldoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['bukti_trf'] = $this->imageServiceV2->upload(name: 'bukti_trf', path: $this->buktiTrfPath, disk: $this->disk);

        TarikSaldo::create(attributes: $validated);

        Alert::success('Berhasil', 'tarik saldo berhasil dibuat.');
        return redirect()->route('tarik-saldos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TarikSaldo $tarikSaldo): View
    {
        $tarikSaldo->load(relations: ['merchant:id,nama_merchant', 'bank:id,nama_bank', ]);

		return view(view: 'tarik-saldos.show', data: compact(var_name: 'tarikSaldo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TarikSaldo $tarikSaldo): View
    {
        $tarikSaldo->load(relations: ['merchant:id,nama_merchant', 'bank:id,nama_bank', ]);

		return view(view: 'tarik-saldos.edit', data: compact(var_name: 'tarikSaldo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTarikSaldoRequest $request, TarikSaldo $tarikSaldo): RedirectResponse
    {
        $validated = $request->validated();

        $validated['bukti_trf'] = $this->imageServiceV2->upload(name: 'bukti_trf', path: $this->buktiTrfPath, defaultImage: $tarikSaldo?->bukti_trf, disk: $this->disk);

        $tarikSaldo->update(attributes: $validated);

        Alert::success('Berhasil', 'tarik saldo berhasil diperbarui.');
        return redirect()->route('tarik-saldos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TarikSaldo $tarikSaldo): RedirectResponse
    {
        try {
            $buktiTrf = $tarikSaldo->bukti_trf;

            $tarikSaldo->delete();

            $this->imageServiceV2->delete(path: $this->buktiTrfPath, image: $buktiTrf, disk: $this->disk);


            Alert::success('Berhasil', 'tarik saldo berhasil dihapus.');
            return redirect()->route('tarik-saldos.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'tarik saldo tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('tarik-saldos.index');
        }
    }


}
