<?php

namespace App\Http\Controllers;

use App\Models\TarikSaldo;
use App\Http\Requests\TarikSaldos\{StoreTarikSaldoRequest, UpdateTarikSaldoRequest, ConfirmTarikSaldoRequest, UpdateStatusTarikSaldoRequest};
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
    public function __construct(public ImageServiceV2 $imageServiceV2, public string $buktiTrfPath = 'bukti-trves', public string $disk = 'storage.public')
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

            new Middleware(middleware: 'permission:tarik saldo view', only: ['index', 'show', 'getMerchantData', 'summary']),
            new Middleware(middleware: 'permission:pengajuan tarik saldo', only: ['store']),
            new Middleware(middleware: 'permission:konfirmasi tarik saldo', only: ['update', 'confirm', 'updateStatus']),
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

            $query->orderByDesc('tarik_saldos.created_at');

            $imageService = app(ImageServiceV2::class);
            return Datatables::of($query)
                ->editColumn('bukti_trf', function ($row) use ($imageService) {
                    if (empty($row->bukti_trf)) {
                        return null;
                    }
                    return $imageService->getImageCastUrl($row->bukti_trf, 'bukti-trves', 'storage.public');
                })
                ->addColumn(name: 'action', content: 'tarik-saldos.include.action')
                ->toJson();
        }

        $summary = null;
        $merchantId = session('sessionMerchant');
        if ($merchantId) {
            $merchant = DB::table('merchants')
                ->leftJoin('banks', 'merchants.bank_id', '=', 'banks.id')
                ->where('merchants.id', $merchantId)
                ->select(
                    'merchants.id',
                    'merchants.nama_merchant',
                    'merchants.balance',
                    'merchants.pemilik_rekening',
                    'merchants.nomor_rekening',
                    'banks.nama_bank as bank_nama'
                )
                ->first();
            if ($merchant) {
                $pendingCount = DB::table('tarik_saldos')
                    ->where('merchant_id', $merchantId)
                    ->whereIn('status', ['pending', 'process'])
                    ->count();
                $successCount = DB::table('tarik_saldos')
                    ->where('merchant_id', $merchantId)
                    ->where('status', 'success')
                    ->count();
                $totalDitarikan = (float) DB::table('tarik_saldos')
                    ->where('merchant_id', $merchantId)
                    ->where('status', 'success')
                    ->sum('diterima');
                $summary = (object) [
                    'nama_merchant' => $merchant->nama_merchant,
                    'balance' => (float) ($merchant->balance ?? 0),
                    'bank' => $merchant->bank_nama ?? '-',
                    'nomor_rekening' => $merchant->nomor_rekening ?? '-',
                    'pemilik_rekening' => $merchant->pemilik_rekening ?? '-',
                    'pending_count' => $pendingCount,
                    'success_count' => $successCount,
                    'total_ditarikan' => $totalDitarikan,
                ];
            }
        }

        return view(view: 'tarik-saldos.index', data: compact('summary'));
    }

    /**
     * Get summary (balance, pending_count, etc.) for current session merchant - untuk update card setelah konfirmasi.
     */
    public function summary(): JsonResponse
    {
        $merchantId = session('sessionMerchant');
        if (!$merchantId) {
            return response()->json(['error' => 'Merchant tidak ditemukan di session'], 404);
        }

        $merchant = DB::table('merchants')
            ->leftJoin('banks', 'merchants.bank_id', '=', 'banks.id')
            ->where('merchants.id', $merchantId)
            ->select(
                'merchants.nama_merchant',
                'merchants.balance',
                'merchants.pemilik_rekening',
                'merchants.nomor_rekening',
                'banks.nama_bank as bank_nama'
            )
            ->first();

        if (!$merchant) {
            return response()->json(['error' => 'Data merchant tidak ditemukan'], 404);
        }

        $pendingCount = DB::table('tarik_saldos')
            ->where('merchant_id', $merchantId)
            ->whereIn('status', ['pending', 'process'])
            ->count();
        $successCount = DB::table('tarik_saldos')
            ->where('merchant_id', $merchantId)
            ->where('status', 'success')
            ->count();
        $totalDitarikan = (float) DB::table('tarik_saldos')
            ->where('merchant_id', $merchantId)
            ->where('status', 'success')
            ->sum('diterima');

        return response()->json([
            'balance' => (float) ($merchant->balance ?? 0),
            'pending_count' => $pendingCount,
            'success_count' => $successCount,
            'total_ditarikan' => $totalDitarikan,
            'bank' => $merchant->bank_nama ?? '-',
            'nomor_rekening' => $merchant->nomor_rekening ?? '-',
            'pemilik_rekening' => $merchant->pemilik_rekening ?? '-',
        ]);
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

        $biaya = 7500;
        $diterima = $validated['jumlah'] - $biaya;
        $validated['merchant_id'] = $merchantId;
        $validated['bank_id'] = $merchant->bank_id;
        $validated['biaya'] = $biaya;
        $validated['diterima'] = $diterima;
        $validated['pemilik_rekening'] = $merchant->pemilik_rekening;
        $validated['nomor_rekening'] = $merchant->nomor_rekening;
        $validated['status'] = 'pending';
        $validated['bukti_trf'] = null;
        $validated['id'] = (string) Str::uuid();
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        try {
            DB::transaction(function () use ($merchantId, $validated, $biaya, $diterima) {
                $merchant = DB::table('merchants')->where('id', $merchantId)->lockForUpdate()->first();
                if (!$merchant) {
                    throw new \RuntimeException('Data merchant tidak ditemukan.');
                }
                if ($merchant->balance < $validated['jumlah']) {
                    throw new \RuntimeException('Saldo tidak mencukupi untuk melakukan penarikan.');
                }
                $existingWithdrawal = DB::table('tarik_saldos')
                    ->where('merchant_id', $merchantId)
                    ->whereIn('status', ['pending', 'process'])
                    ->exists();
                if ($existingWithdrawal) {
                    throw new \RuntimeException('Anda masih memiliki pengajuan penarikan yang sedang diproses. Tunggu hingga selesai sebelum mengajukan penarikan baru.');
                }
                DB::table('tarik_saldos')->insert($validated);
            });
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            if ($request->ajax()) {
                return response()->json(['message' => $message], 400);
            }
            Alert::error('Gagal', $message);
            return redirect()->back()->withInput();
        }

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

        $buktiTrfUrl = null;
        if (!empty($tarikSaldo->bukti_trf)) {
            $buktiTrfUrl = $this->imageServiceV2->getImageCastUrl($tarikSaldo->bukti_trf, 'bukti-trves', 'storage.public');
        }

        return view(view: 'tarik-saldos.show', data: compact('tarikSaldo', 'buktiTrfUrl'));
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
        $merchantId = session('sessionMerchant');

        try {
            DB::transaction(function () use ($id, $merchantId) {
                $tarikSaldo = TarikSaldo::where('id', $id)->lockForUpdate()->first();
                if (!$tarikSaldo) {
                    throw new \RuntimeException('Data tarik saldo tidak ditemukan.');
                }
                if ($tarikSaldo->merchant_id !== $merchantId) {
                    throw new \RuntimeException('Anda tidak memiliki akses untuk membatalkan pengajuan ini.');
                }
                if ($tarikSaldo->status !== 'pending') {
                    throw new \RuntimeException('Hanya pengajuan dengan status pending yang dapat dibatalkan.');
                }
                $tarikSaldo->update(['status' => 'cancel', 'updated_at' => now()]);
            });
        } catch (\Throwable $e) {
            $code = $e->getMessage() === 'Data tarik saldo tidak ditemukan.' ? 404
                : (str_contains($e->getMessage(), 'akses') ? 403 : 400);
            return response()->json(['message' => $e->getMessage()], $code);
        }

        return response()->json(['message' => 'Pengajuan penarikan berhasil dibatalkan.'], 200);
    }

    /**
     * Ubah status dari pending ke process atau reject (admin).
     */
    public function updateStatus(UpdateStatusTarikSaldoRequest $request, string $id): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();
        $status = $validated['status'];
        $label = $status === 'process' ? 'Diproses' : 'Ditolak';

        try {
            DB::transaction(function () use ($id, $status, $validated) {
                $tarikSaldo = TarikSaldo::where('id', $id)->lockForUpdate()->first();
                if (!$tarikSaldo) {
                    throw new \RuntimeException('Data tarik saldo tidak ditemukan.');
                }
                if ($tarikSaldo->status !== 'pending') {
                    throw new \RuntimeException('Hanya pengajuan dengan status Pending yang dapat diubah ke Diproses/Ditolak.');
                }
                $payload = ['status' => $status, 'updated_at' => now()];
                if (array_key_exists('catatan', $validated)) {
                    $payload['catatan'] = $validated['catatan'];
                }
                $tarikSaldo->update($payload);
            });
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => $message], $message === 'Data tarik saldo tidak ditemukan.' ? 404 : 400);
            }
            Alert::error('Gagal', $message);
            return redirect()->route('tarik-saldos.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => "Status berhasil diubah menjadi {$label}."], 200);
        }
        Alert::success('Berhasil', "Status berhasil diubah menjadi {$label}.");
        return redirect()->route('tarik-saldos.index');
    }

    /**
     * Konfirmasi selesai (admin): hanya untuk status process. Upload bukti + catatan, set success, kurangi saldo merchant.
     */
    public function confirm(ConfirmTarikSaldoRequest $request, string $id): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        try {
            $tarikSaldo = TarikSaldo::where('id', $id)->first();
            if (!$tarikSaldo) {
                throw new \RuntimeException('Data tarik saldo tidak ditemukan.');
            }
            if ($tarikSaldo->status !== 'process') {
                throw new \RuntimeException('Hanya pengajuan dengan status Diproses yang dapat dikonfirmasi selesai (upload bukti + catatan).');
            }

            $buktiTrf = $this->imageServiceV2->upload(
                name: 'bukti_trf',
                path: $this->buktiTrfPath,
                defaultImage: $tarikSaldo->getRawOriginal('bukti_trf'),
                disk: $this->disk
            );

            DB::transaction(function () use ($id, $buktiTrf, $validated) {
                $row = TarikSaldo::where('id', $id)->lockForUpdate()->first();
                if (!$row || $row->status !== 'process') {
                    throw new \RuntimeException('Status pengajuan sudah berubah. Silakan refresh dan coba lagi.');
                }
                $row->update([
                    'status' => 'success',
                    'bukti_trf' => $buktiTrf,
                    'catatan' => $validated['catatan'] ?? null,
                    'updated_at' => now(),
                ]);
                DB::table('merchants')->where('id', $row->merchant_id)->lockForUpdate()->first();
                DB::table('merchants')->where('id', $row->merchant_id)->decrement('balance', (float) $row->jumlah);
            });
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => $message], $message === 'Data tarik saldo tidak ditemukan.' ? 404 : 400);
            }
            Alert::error('Gagal', $message);
            return redirect()->route('tarik-saldos.index');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Tarik saldo berhasil dikonfirmasi. Saldo merchant telah dikurangi.'], 200);
        }
        Alert::success('Berhasil', 'Tarik saldo berhasil dikonfirmasi. Saldo merchant telah dikurangi.');
        return redirect()->route('tarik-saldos.index');
    }
}
