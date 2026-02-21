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
        public string $ktpLembarVerifikasiPath = 'ktp-lembar-verifikasi',
        public string $ktpPhotoSelfiePath = 'ktp-photo-selfie',
        public string $photoTokoPath = 'photo-toko-tampak-depan',
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

        $merchant = Merchant::find($merchantId);

        if (! $merchant) {
            abort(404, 'Data merchant tidak ditemukan.');
        }

        $banks = DB::table('banks')
            ->orderBy('nama_bank')
            ->get();

        return view('setting-merchant', compact('merchant', 'banks'));
    }

    public function update(UpdateMerchantRequest $request): RedirectResponse
    {
        $merchantId = session('sessionMerchant');
        if (! $merchantId) {
            abort(403, 'Merchant tidak ditemukan di session.');
        }
        $merchant = Merchant::findOrFail($merchantId);

        $validated = $request->validated();

        $validated['logo'] = $this->imageServiceV2->upload(name: 'logo', path: $this->logoPath, defaultImage: $merchant->getRawOriginal('logo'), disk: $this->disk);
        $validated['ktp'] = $this->imageServiceV2->upload(name: 'ktp', path: $this->ktpPath, defaultImage: $merchant->getRawOriginal('ktp'), disk: $this->disk);
        $validated['ktp_lembar_verifikasi'] = $this->imageServiceV2->upload(name: 'ktp_lembar_verifikasi', path: $this->ktpLembarVerifikasiPath, defaultImage: $merchant->getRawOriginal('ktp_lembar_verifikasi'), disk: $this->disk);
        $validated['ktp_photo_selfie'] = $this->imageServiceV2->upload(name: 'ktp_photo_selfie', path: $this->ktpPhotoSelfiePath, defaultImage: $merchant->getRawOriginal('ktp_photo_selfie'), disk: $this->disk);
        $validated['photo_toko_tampak_depan'] = $this->imageServiceV2->upload(name: 'photo_toko_tampak_depan', path: $this->photoTokoPath, defaultImage: $merchant->getRawOriginal('photo_toko_tampak_depan'), disk: $this->disk);

        $merchant->update(attributes: $validated);

        Alert::success('Berhasil', 'Merchant berhasil diperbarui.');
        return redirect()->route('setting-merchant.index');
    }

    public function switchMerchant(Request $request): JsonResponse
    {
        $merchantId = $request->input('merchant_id');
        $userId = auth()->id();

        // Validate that user has access to this merchant
        $hasAccess = DB::table('assign_merchants')
            ->where('user_id', $userId)
            ->where('merchant_id', $merchantId)
            ->exists();

        if (!$hasAccess) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        // Update session
        session(['sessionMerchant' => $merchantId]);

        return response()->json(['success' => true]);
    }
}
