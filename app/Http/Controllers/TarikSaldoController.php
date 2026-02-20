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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'auth',

            new Middleware(middleware: 'permission:tarik saldo view', only: ['index', 'show', 'getMerchantData']),
            new Middleware(middleware: 'permission:pengajuan tarik saldo', only: ['store']),
            new Middleware(middleware: 'permission:konfirmasi tarik saldo', only: ['update']),
            new Middleware(middleware: 'permission:batalkan tarik saldo', only: ['cancel']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            // Filter by session merchant - no data if no session
            $merchantId = session('sessionMerchant');

            $query = DB::table('tarik_saldos')
                ->leftJoin('merchants', 'tarik_saldos.merchant_id', '=', 'merchants.id')
                ->leftJoin('banks', 'tarik_saldos.bank_id', '=', 'banks.id')
                ->select(
                    'tarik_saldos.*',
                    'merchants.nama_merchant as merchant',
                    'banks.nama_bank as bank'
                );

            if ($merchantId) {
                $query->where('tarik_saldos.merchant_id', $merchantId);
            } else {
                $query->whereRaw('1 = 0'); // Return empty if no merchant session
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn(name: 'action', content: 'tarik-saldos.include.action')
                ->toJson();
        }

        return view(view: 'tarik-saldos.index');
    }

    /**
     * Get merchant data for withdrawal modal
     */
    public function getMerchantData(): JsonResponse
    {
        $merchantId = session('sessionMerchant');
        if (!$merchantId) {
            return response()->json(['error' => 'Merchant tidak ditemukan di session'], 404);
        }

        $merchant = DB::table('merchants')
            ->leftJoin('banks', 'merchants.bank_id', '=', 'banks.id')
            ->where('merchants.id', $merchantId)
            ->select(
                'merchants.id',
                'merchants.nama_merchant',
                'merchants.balance',
                'merchants.bank_id',
                'merchants.pemilik_rekening',
                'merchants.nomor_rekening',
                'banks.nama_bank as bank_nama_bank'
            )
            ->first();

        if (!$merchant) {
            return response()->json(['error' => 'Data merchant tidak ditemukan'], 404);
        }

        // Format response to match previous structure
        $response = [
            'id' => $merchant->id,
            'nama_merchant' => $merchant->nama_merchant,
            'balance' => $merchant->balance,
            'bank_id' => $merchant->bank_id,
            'pemilik_rekening' => $merchant->pemilik_rekening,
            'nomor_rekening' => $merchant->nomor_rekening,
            'bank' => $merchant->bank_nama_bank ? ['nama_bank' => $merchant->bank_nama_bank] : null
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTarikSaldoRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        // Get merchant from session
        $merchantId = session('sessionMerchant');
        if (!$merchantId) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Merchant tidak ditemukan di session.'], 400);
            }
            Alert::error('Gagal', 'Merchant tidak ditemukan di session.');
            return redirect()->back();
        }

        // Get merchant data
        $merchant = DB::table('merchants')->where('id', $merchantId)->first();
        if (!$merchant || !$merchant->bank_id) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Data bank merchant tidak ditemukan. Silakan lengkapi data merchant terlebih dahulu.'], 400);
            }
            Alert::error('Gagal', 'Data bank merchant tidak ditemukan. Silakan lengkapi data merchant terlebih dahulu.');
            return redirect()->back();
        }

        // Check if there's already a pending or processing withdrawal
        $existingWithdrawal = DB::table('tarik_saldos')
            ->where('merchant_id', $merchantId)
            ->whereIn('status', ['pending', 'process'])
            ->exists();

        if ($existingWithdrawal) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Anda masih memiliki pengajuan penarikan yang sedang diproses. Tunggu hingga selesai sebelum mengajukan penarikan baru.'], 400);
            }
            Alert::error('Gagal', 'Anda masih memiliki pengajuan penarikan yang sedang diproses. Tunggu hingga selesai sebelum mengajukan penarikan baru.');
            return redirect()->back()->withInput();
        }

        // Check if merchant has enough balance
        if ($merchant->balance < $validated['jumlah']) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Saldo tidak mencukupi untuk melakukan penarikan.'], 400);
            }
            Alert::error('Gagal', 'Saldo tidak mencukupi untuk melakukan penarikan.');
            return redirect()->back()->withInput();
        }

        // Calculate biaya and diterima
        $biaya = 7500; // Fixed admin fee
        $diterima = $validated['jumlah'] - $biaya;

        // Auto-fill data from merchant
        $validated['merchant_id'] = $merchantId;
        $validated['bank_id'] = $merchant->bank_id;
        $validated['biaya'] = $biaya;
        $validated['diterima'] = $diterima;
        $validated['pemilik_rekening'] = $merchant->pemilik_rekening;
        $validated['nomor_rekening'] = $merchant->nomor_rekening;
        $validated['status'] = 'pending';
        $validated['bukti_trf'] = null; // Will be uploaded by admin later
        $validated['id'] = (string) Str::uuid();
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        DB::table('tarik_saldos')->insert($validated);

        if ($request->ajax()) {
            return response()->json(['message' => 'Pengajuan penarikan saldo berhasil dibuat. Penarikan akan diproses maksimal 1x24 jam.'], 200);
        }

        Alert::success('Berhasil', 'Pengajuan penarikan saldo berhasil dibuat. Penarikan akan diproses maksimal 1x24 jam.');
        return redirect()->route('tarik-saldos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $tarikSaldo = DB::table('tarik_saldos')
            ->leftJoin('merchants', 'tarik_saldos.merchant_id', '=', 'merchants.id')
            ->leftJoin('banks', 'tarik_saldos.bank_id', '=', 'banks.id')
            ->where('tarik_saldos.id', $id)
            ->select(
                'tarik_saldos.*',
                'merchants.nama_merchant',
                'banks.nama_bank'
            )
            ->first();

        if (!$tarikSaldo) {
            Alert::error('Gagal', 'Data tarik saldo tidak ditemukan.');
            return redirect()->route('tarik-saldos.index');
        }

		return view(view: 'tarik-saldos.show', data: compact(var_name: 'tarikSaldo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTarikSaldoRequest $request, string $id): RedirectResponse
    {
        $validated = $request->validated();

        $tarikSaldo = DB::table('tarik_saldos')->where('id', $id)->first();
        if (!$tarikSaldo) {
            Alert::error('Gagal', 'Data tarik saldo tidak ditemukan.');
            return redirect()->route('tarik-saldos.index');
        }

        $validated['bukti_trf'] = $this->imageServiceV2->upload(name: 'bukti_trf', path: $this->buktiTrfPath, defaultImage: $tarikSaldo->bukti_trf, disk: $this->disk);
        $validated['updated_at'] = now();

        DB::table('tarik_saldos')->where('id', $id)->update($validated);

        Alert::success('Berhasil', 'tarik saldo berhasil diperbarui.');
        return redirect()->route('tarik-saldos.index');
    }

    /**
     * Cancel pending withdrawal
     */
    public function cancel(string $id): JsonResponse
    {
        $tarikSaldo = DB::table('tarik_saldos')->where('id', $id)->first();

        if (!$tarikSaldo) {
            return response()->json(['message' => 'Data tarik saldo tidak ditemukan.'], 404);
        }

        // Check if withdrawal belongs to session merchant
        $merchantId = session('sessionMerchant');
        if ($tarikSaldo->merchant_id !== $merchantId) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk membatalkan pengajuan ini.'], 403);
        }

        // Check if withdrawal is still pending
        if ($tarikSaldo->status !== 'pending') {
            return response()->json(['message' => 'Hanya pengajuan dengan status pending yang dapat dibatalkan.'], 400);
        }

        // Update status to cancel instead of deleting
        DB::table('tarik_saldos')->where('id', $id)->update([
            'status' => 'cancel',
            'updated_at' => now()
        ]);

        return response()->json(['message' => 'Pengajuan penarikan berhasil dibatalkan.'], 200);
    }


}
