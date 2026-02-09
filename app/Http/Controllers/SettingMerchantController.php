<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Http\Requests\Merchants\{UpdateMerchantRequest};
use Illuminate\Contracts\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingMerchantController extends Controller implements HasMiddleware
{
    public function __construct(
        public ImageServiceV2 $imageServiceV2,
        public string $logoPath = 'logos',
        public string $ktpPath = 'ktps',
        public string $disk = 'public'
    ) {
        //
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:setting merchant', only: ['index', 'update']),
        ];
    }

    public function index(): View|JsonResponse
    {
        $merchantId = session('sessionMerchant');

        if (! $merchantId) {
            abort(403, 'Merchant tidak ditemukan di session.');
        }

        $merchant = DB::table('merchants')
            ->where('id', $merchantId)
            ->first();

        if (! $merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $banks = DB::table('banks')
            ->orderBy('nama_bank')
            ->get();

        return view('setting-merchant', compact('merchant', 'banks'));
    }

    public function update(UpdateMerchantRequest $request, Merchant $merchant): RedirectResponse
    {
        $validated = $request->validated();

        $validated['logo'] = $this->imageServiceV2->upload(name: 'logo', path: $this->logoPath, defaultImage: $merchant?->logo, disk: $this->disk);
        $validated['ktp'] = $this->imageServiceV2->upload(name: 'ktp', path: $this->ktpPath, defaultImage: $merchant?->ktp, disk: $this->disk);

        $merchant->update(attributes: $validated);

        Alert::success('Berhasil', 'Merchant berhasil diperbarui.');
        return redirect()->route('merchants.index');
    }
}
