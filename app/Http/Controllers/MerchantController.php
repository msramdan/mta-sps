<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Http\Requests\Merchants\{StoreMerchantRequest, UpdateMerchantRequest};
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class MerchantController extends Controller implements HasMiddleware
{
    public function __construct(public ImageServiceV2 $imageServiceV2, public string $logoPath = 'logos', public string $disk = 'public')
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
            // new Middleware(middleware: 'permission:merchant view', only: ['index', 'show']),
            // new Middleware(middleware: 'permission:merchant create', only: ['create', 'store']),
            // new Middleware(middleware: 'permission:merchant edit', only: ['edit', 'update']),
            // new Middleware(middleware: 'permission:merchant delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $merchants = Merchant::with(relations: ['bank:id,nama_bank', ]);

            return Datatables::of(source: $merchants)
                ->addColumn(name: 'bank', content: fn($row): ?string => $row?->bank?->nama_bank ?? '')
				
                ->addColumn(name: 'action', content: 'merchants.include.action')
                ->toJson();
        }

        return view(view: 'merchants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(view: 'merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMerchantRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $validated['logo'] = $this->imageServiceV2->upload(name: 'logo', path: $this->logoPath, disk: $this->disk);

        Merchant::create(attributes: $validated);

        Alert::success('Berhasil', 'merchant berhasil dibuat.');
        return redirect()->route('merchants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): View
    {
        $merchant->load(relations: ['bank:id,nama_bank', ]);

		return view(view: 'merchants.show', data: compact(var_name: 'merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchant $merchant): View
    {
        $merchant->load(relations: ['bank:id,nama_bank', ]);

		return view(view: 'merchants.edit', data: compact(var_name: 'merchant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMerchantRequest $request, Merchant $merchant): RedirectResponse
    {
        $validated = $request->validated();
        
        $validated['logo'] = $this->imageServiceV2->upload(name: 'logo', path: $this->logoPath, defaultImage: $merchant?->logo, disk: $this->disk);

        $merchant->update(attributes: $validated);

        Alert::success('Berhasil', 'merchant berhasil diperbarui.');
        return redirect()->route('merchants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchant $merchant): RedirectResponse
    {
        try {
            $logo = $merchant->logo;
			
            $merchant->delete();

            $this->imageServiceV2->delete(path: $this->logoPath, image: $logo, disk: $this->disk);

			
            Alert::success('Berhasil', 'merchant berhasil dihapus.');
            return redirect()->route('merchants.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'merchant tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('merchants.index');
        }
    }

    
}
