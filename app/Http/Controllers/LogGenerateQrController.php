<?php

namespace App\Http\Controllers;

use App\Models\LogGenerateQr;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LogGenerateQrController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:log generate qr view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:log generate qr delete', only: ['destroy', 'bulkDestroy', 'truncate']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogGenerateQr::with('merchant:id,nama_merchant,kode_merchant')
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);

            if (request()->filled('merchant_id')) {
                $query->where('merchant_id', request('merchant_id'));
            }

            if (request()->filled('status')) {
                if (request('status') === '1') {
                    $query->where('is_success', true);
                } elseif (request('status') === '0') {
                    $query->where('is_success', false);
                }
            }

            $query->latest();

            return DataTables::of($query)
                ->addColumn('checkbox', function ($log) {
                    return '<input type="checkbox" class="form-check-input log-row-checkbox" value="' . $log->id . '">';
                })
                ->addColumn('action', 'log-generate-qrs.include.action')
                ->editColumn('merchant_id', function ($log) {
                    return $log->merchant ? $log->merchant->nama_merchant . ' (' . $log->merchant->kode_merchant . ')' : '-';
                })
                ->editColumn('is_success', function ($log) {
                    return $log->is_success
                        ? '<span class="badge bg-success">Sukses</span>'
                        : '<span class="badge bg-danger">Gagal</span>';
                })
                ->editColumn('created_at', function ($log) {
                    return $log->created_at?->format('d/m/Y H:i');
                })
                ->editColumn('processing_time', function ($log) {
                    return $log->processing_time ?? '-';
                })
                ->rawColumns(['checkbox', 'is_success', 'action'])
                ->make(true);
        }

        $merchants = Merchant::orderBy('nama_merchant')->get(['id', 'nama_merchant', 'kode_merchant']);
        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('log-generate-qrs.index', compact('merchants', 'defaultDateFrom', 'defaultDateTo'));
    }

    public function show(LogGenerateQr $logGenerateQr): View
    {
        $logGenerateQr->load('merchant:id,nama_merchant,kode_merchant');
        return view('log-generate-qrs.show', compact('logGenerateQr'));
    }

    public function destroy(LogGenerateQr $logGenerateQr): RedirectResponse
    {
        $logGenerateQr->delete();
        Alert::success('Berhasil', 'Log Generate QR berhasil dihapus.');
        return redirect()->route('log-generate-qrs.index');
    }

    public function bulkDestroy(Request $request): RedirectResponse|JsonResponse
    {
        $ids = $request->input('ids', []);
        if (! is_array($ids)) {
            $ids = array_filter(explode(',', (string) $ids));
        }
        $ids = array_map('intval', array_filter($ids));
        if (count($ids) === 0) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data dipilih.'], 422);
            }
            Alert::warning('Peringatan', 'Tidak ada data dipilih.');
            return redirect()->route('log-generate-qrs.index');
        }
        LogGenerateQr::whereIn('id', $ids)->delete();
        Alert::success('Berhasil', count($ids) . ' log berhasil dihapus.');
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($ids) . ' log berhasil dihapus.']);
        }
        return redirect()->route('log-generate-qrs.index');
    }

    public function truncate(): RedirectResponse
    {
        LogGenerateQr::query()->delete();
        Alert::success('Berhasil', 'Semua data Log Generate QR telah dikosongkan.');
        return redirect()->route('log-generate-qrs.index');
    }
}
