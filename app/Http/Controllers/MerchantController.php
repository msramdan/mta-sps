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
use Illuminate\Http\Request;

class MerchantController extends Controller implements HasMiddleware
{
    public ImageServiceV2 $imageServiceV2;
    public string $logoPath;
    public string $ktpPath;
    public string $ktpLembarVerifikasiPath;
    public string $ktpPhotoSelfiePath;
    public string $photoTokoPath;
    public string $disk;

    public function __construct(
        ImageServiceV2 $imageServiceV2,
        string $logoPath = 'logos',
        string $ktpPath = 'ktps',
        string $ktpLembarVerifikasiPath = 'ktp-lembar-verifikasi',
        string $ktpPhotoSelfiePath = 'ktp-photo-selfie',
        string $photoTokoPath = 'photo-toko-tampak-depan',
        string $disk = 's3'
    ) {
        $this->imageServiceV2 = $imageServiceV2;
        $this->logoPath = $logoPath;
        $this->ktpPath = $ktpPath;
        $this->ktpLembarVerifikasiPath = $ktpLembarVerifikasiPath;
        $this->ktpPhotoSelfiePath = $ktpPhotoSelfiePath;
        $this->photoTokoPath = $photoTokoPath;
        $this->disk = $disk;
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:merchant view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:merchant create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:merchant edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:merchant delete', only: ['destroy']),
            new Middleware(middleware: 'permission:merchant review', only: ['review']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $merchants = Merchant::with(relations: ['bank:id,nama_bank'])->orderByDesc('created_at');

            return Datatables::of(source: $merchants)
                ->editColumn('beban_biaya', fn ($row) => $row->beban_biaya === 'Pelanggan'
                    ? '<span class="badge bg-info">Pelanggan</span>'
                    : '<span class="badge bg-primary">Merchant</span>')
                ->addColumn(name: 'action', content: 'merchants.include.action')
                ->rawColumns(['beban_biaya', 'action'])
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

        $validated['logo'] = $this->imageServiceV2->upload(
            name: 'logo',
            path: $this->logoPath,
            defaultImage: null,
            disk: $this->disk
        );
        $validated['ktp'] = $this->imageServiceV2->upload(
            name: 'ktp',
            path: $this->ktpPath,
            defaultImage: null,
            disk: $this->disk
        );
        $validated['ktp_lembar_verifikasi'] = $this->imageServiceV2->upload(
            name: 'ktp_lembar_verifikasi',
            path: $this->ktpLembarVerifikasiPath,
            defaultImage: null,
            disk: $this->disk
        );
        $validated['ktp_photo_selfie'] = $this->imageServiceV2->upload(
            name: 'ktp_photo_selfie',
            path: $this->ktpPhotoSelfiePath,
            defaultImage: null,
            disk: $this->disk
        );
        $validated['photo_toko_tampak_depan'] = $this->imageServiceV2->upload(
            name: 'photo_toko_tampak_depan',
            path: $this->photoTokoPath,
            defaultImage: null,
            disk: $this->disk
        );

        Merchant::create(attributes: $validated);

        Alert::success('Berhasil', 'Merchant berhasil dibuat.');
        return redirect()->route('merchants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): View
    {
        $merchant->load(relations: ['bank:id,nama_bank']);

        return view(view: 'merchants.show', data: compact(var_name: 'merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchant $merchant): View
    {
        $merchant->load(relations: ['bank:id,nama_bank']);

        return view(view: 'merchants.edit', data: compact(var_name: 'merchant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMerchantRequest $request, Merchant $merchant): RedirectResponse
    {
        $validated = $request->validated();

        // Exclude kode_merchant from update (should never be updated)
        unset($validated['kode_merchant']);

        // Tidak ada upload → skip, tetap pakai berkas lama. Ada upload baru → upload ke RustFS dan replace.
        $validated['logo'] = $this->uploadOrKeep(
            $request,
            'logo',
            $this->logoPath,
            $merchant->getRawOriginal('logo')
        );
        $validated['ktp'] = $this->uploadOrKeep(
            $request,
            'ktp',
            $this->ktpPath,
            $merchant->getRawOriginal('ktp')
        );
        $validated['ktp_lembar_verifikasi'] = $this->uploadOrKeep(
            $request,
            'ktp_lembar_verifikasi',
            $this->ktpLembarVerifikasiPath,
            $merchant->getRawOriginal('ktp_lembar_verifikasi')
        );
        $validated['ktp_photo_selfie'] = $this->uploadOrKeep(
            $request,
            'ktp_photo_selfie',
            $this->ktpPhotoSelfiePath,
            $merchant->getRawOriginal('ktp_photo_selfie')
        );
        $validated['photo_toko_tampak_depan'] = $this->uploadOrKeep(
            $request,
            'photo_toko_tampak_depan',
            $this->photoTokoPath,
            $merchant->getRawOriginal('photo_toko_tampak_depan')
        );

        $merchant->update(attributes: $validated);

        Alert::success('Berhasil', 'Merchant berhasil diperbarui.');
        return redirect()->route('merchants.index');
    }

    /**
     * Upload file baru ke RustFS (replace lama) hanya jika ada file; bila tidak, tetap pakai nilai lama.
     */
    private function uploadOrKeep($request, string $name, string $path, ?string $currentValue): ?string
    {
        if ($request->hasFile($name) && $request->file($name)->isValid()) {
            return $this->imageServiceV2->upload(
                name: $name,
                path: $path,
                defaultImage: $currentValue,
                disk: $this->disk
            );
        }

        return $currentValue;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchant $merchant): RedirectResponse
    {
        try {
            $logo = $merchant->getRawOriginal('logo');
            $ktp = $merchant->getRawOriginal('ktp');
            $ktpLembarVerifikasi = $merchant->getRawOriginal('ktp_lembar_verifikasi');
            $ktpPhotoSelfie = $merchant->getRawOriginal('ktp_photo_selfie');
            $photoToko = $merchant->getRawOriginal('photo_toko_tampak_depan');

            $merchant->delete();

            $this->imageServiceV2->delete(path: $this->logoPath, image: $logo, disk: $this->disk);
            $this->imageServiceV2->delete(path: $this->ktpPath, image: $ktp, disk: $this->disk);
            $this->imageServiceV2->delete(path: $this->ktpLembarVerifikasiPath, image: $ktpLembarVerifikasi, disk: $this->disk);
            $this->imageServiceV2->delete(path: $this->ktpPhotoSelfiePath, image: $ktpPhotoSelfie, disk: $this->disk);
            $this->imageServiceV2->delete(path: $this->photoTokoPath, image: $photoToko, disk: $this->disk);

            Alert::success('Berhasil', 'Merchant berhasil dihapus.');
            return redirect()->route('merchants.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Merchant tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('merchants.index');
        }
    }

    public function review(Request $request, Merchant $merchant): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,suspended',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $merchant->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        // Text human readable
        $statusText = match ($request->status) {
            'pending'   => 'diset ke status pending',
            'approved'  => 'disetujui',
            'rejected'  => 'ditolak',
            'suspended' => 'ditangguhkan',
        };

        Alert::success('Berhasil', "Merchant berhasil {$statusText}.");
        return redirect()->route('merchants.show', $merchant->id);
    }

    /**
     * Get Tecanusa credential (from first merchant)
     */
    public function tecanusaCredential(): JsonResponse
    {
        $merchant = Merchant::whereNotNull('nobu_client_id')
            ->whereNotNull('nobu_private_key')
            ->first();

        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial Tecanusa tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'nobu_client_id' => $merchant->nobu_client_id,
                'nobu_partner_id' => $merchant->nobu_partner_id,
                'nobu_client_secret' => $merchant->nobu_client_secret,
                'nobu_merchant_id' => $merchant->nobu_merchant_id,
                'nobu_sub_merchant_id' => $merchant->nobu_sub_merchant_id,
                'nobu_store_id' => $merchant->nobu_store_id,
                'nobu_private_key' => $merchant->nobu_private_key,
            ]
        ]);
    }

    /**
     * Search merchants for AJAX select
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('q', '');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Merchant::query()
            ->select('id', 'nama_merchant', 'kode_merchant')
            ->where('status', 'approved'); // Only show approved merchants

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_merchant', 'LIKE', "%{$search}%")
                  ->orWhere('kode_merchant', 'LIKE', "%{$search}%");
            });
        }

        $total = $query->count();
        $merchants = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $results = $merchants->map(function ($merchant) {
            return [
                'id' => $merchant->id,
                'text' => "{$merchant->nama_merchant} ({$merchant->kode_merchant})",
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }
}

