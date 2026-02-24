<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
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

        // Tidak ada upload → skip, tetap pakai berkas lama. Ada upload baru → replace.
        $validated['logo'] = $this->uploadOrKeep($request, 'logo', $this->logoPath, $merchant->getRawOriginal('logo'));
        $validated['ktp'] = $this->uploadOrKeep($request, 'ktp', $this->ktpPath, $merchant->getRawOriginal('ktp'));
        $validated['ktp_lembar_verifikasi'] = $this->uploadOrKeep($request, 'ktp_lembar_verifikasi', $this->ktpLembarVerifikasiPath, $merchant->getRawOriginal('ktp_lembar_verifikasi'));
        $validated['ktp_photo_selfie'] = $this->uploadOrKeep($request, 'ktp_photo_selfie', $this->ktpPhotoSelfiePath, $merchant->getRawOriginal('ktp_photo_selfie'));
        $validated['photo_toko_tampak_depan'] = $this->uploadOrKeep($request, 'photo_toko_tampak_depan', $this->photoTokoPath, $merchant->getRawOriginal('photo_toko_tampak_depan'));

        $merchant->update(attributes: $validated);

        Alert::success('Berhasil', 'Merchant berhasil diperbarui.');
        return redirect()->route('setting-merchant.index');
    }

    /**
     * Upload file baru (replace lama) hanya jika ada file; bila tidak, tetap pakai nilai lama.
     */
    private function uploadOrKeep($request, string $name, string $path, ?string $currentValue): ?string
    {
        if ($request->hasFile($name) && $request->file($name)->isValid()) {
            return $this->imageServiceV2->upload(name: $name, path: $path, defaultImage: $currentValue, disk: $this->disk);
        }

        return $currentValue;
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

        $oldMerchantId = session('sessionMerchant');
        session(['sessionMerchant' => $merchantId]);

        $merchant = Merchant::find($merchantId);
        ActivityLogHelper::log(
            description: 'User switch merchant',
            logName: 'merchant',
            properties: [
                'before' => ['merchant_id' => $oldMerchantId],
                'after' => ['merchant_id' => $merchantId, 'merchant_name' => $merchant?->nama_merchant],
            ],
            subject: $merchant
        );

        return response()->json(['success' => true]);
    }
}
