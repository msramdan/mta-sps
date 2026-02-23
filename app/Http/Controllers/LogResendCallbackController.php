<?php

namespace App\Http\Controllers;

use App\Models\LogResendCallback;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LogResendCallbackController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:log resend callback view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:log resend callback delete', only: ['destroy', 'bulkDestroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogResendCallback::query()
                ->select([
                    'id', 'transaksi_id', 'merchant_id', 'metode', 'url_callback',
                    'tanggal_resend_callback_qrin_to_merchant',
                    'processing_time', 'created_at', 'updated_at',
                ])
                ->with('merchant:id,nama_merchant,kode_merchant')
                ->where(function ($q) use ($dateFrom, $dateTo) {
                    $q->whereDate('created_at', '>=', $dateFrom)
                        ->whereDate('created_at', '<=', $dateTo);
                });

            if (request()->filled('merchant_id')) {
                $query->where('merchant_id', request('merchant_id'));
            }

            $query->latest();

            return DataTables::of($query)
                ->addColumn('checkbox', function ($log) {
                    return '<input type="checkbox" class="form-check-input log-row-checkbox" value="' . $log->id . '">';
                })
                ->addColumn('action', 'log-resend-callbacks.include.action')
                ->editColumn('merchant_id', function ($log) {
                    return $log->merchant ? $log->merchant->nama_merchant . ' (' . $log->merchant->kode_merchant . ')' : '-';
                })
                ->editColumn('metode', function ($log) {
                    return '<span class="badge bg-primary">' . e($log->metode ?? '-') . '</span>';
                })
                ->editColumn('url_callback', function ($log) {
                    $url = $log->url_callback ?? '-';
                    return '<span class="text-break small" title="' . e($url) . '">' . e(Str::limit($url, 50)) . '</span>';
                })
                ->editColumn('tanggal_resend_callback_qrin_to_merchant', function ($log) {
                    return $log->tanggal_resend_callback_qrin_to_merchant?->format('d/m/Y H:i') ?? '-';
                })
                ->editColumn('processing_time', function ($log) {
                    return $log->processing_time ?? '-';
                })
                ->editColumn('created_at', function ($log) {
                    return $log->created_at?->format('d/m/Y H:i');
                })
                ->rawColumns(['checkbox', 'metode', 'url_callback', 'action'])
                ->make(true);
        }

        $merchants = Merchant::orderBy('nama_merchant')->get(['id', 'nama_merchant', 'kode_merchant']);
        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('log-resend-callbacks.index', compact('merchants', 'defaultDateFrom', 'defaultDateTo'));
    }

    public function show(LogResendCallback $logResendCallback): View
    {
        $logResendCallback->load('merchant:id,nama_merchant,kode_merchant');
        return view('log-resend-callbacks.show', compact('logResendCallback'));
    }

    public function destroy(LogResendCallback $logResendCallback): RedirectResponse
    {
        $logResendCallback->delete();
        Alert::success('Berhasil', 'Log Resend Callback berhasil dihapus.');
        return redirect()->route('log-resend-callbacks.index');
    }

    public function bulkDestroy(Request $request): RedirectResponse|JsonResponse
    {
        $ids = $request->input('ids', []);
        if (! is_array($ids)) {
            $ids = array_filter(explode(',', (string) $ids));
        }
        $ids = array_filter($ids);
        if (count($ids) === 0) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada data dipilih.'], 422);
            }
            Alert::warning('Peringatan', 'Tidak ada data dipilih.');
            return redirect()->route('log-resend-callbacks.index');
        }
        LogResendCallback::whereIn('id', $ids)->delete();
        Alert::success('Berhasil', count($ids) . ' log berhasil dihapus.');
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($ids) . ' log berhasil dihapus.']);
        }
        return redirect()->route('log-resend-callbacks.index');
    }
}
