<?php

namespace App\Http\Controllers;

use App\Models\LogCallback;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LogCallbackController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:log callback view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:log callback delete', only: ['destroy', 'bulkDestroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogCallback::with('merchant:id,nama_merchant,kode_merchant')
                ->where(function ($q) use ($dateFrom, $dateTo) {
                    $q->whereDate('created_at', '>=', $dateFrom)
                        ->whereDate('created_at', '<=', $dateTo);
                });

            if (request()->filled('merchant_id')) {
                $query->where('merchant_id', request('merchant_id'));
            }

            if (request()->filled('status')) {
                $query->where('transaction_status', request('status'));
            }

            $query->latest();

            return DataTables::of($query)
                ->addColumn('checkbox', function ($log) {
                    return '<input type="checkbox" class="form-check-input log-row-checkbox" value="' . $log->id . '">';
                })
                ->addColumn('action', 'log-callbacks.include.action')
                ->editColumn('merchant_id', function ($log) {
                    return $log->merchant ? $log->merchant->nama_merchant . ' (' . $log->merchant->kode_merchant . ')' : '-';
                })
                ->addColumn('status_info', function ($log) {
                    $status = $log->transaction_status ?? '';
                    $statusBadge = $status === '00'
                        ? '<span class="badge bg-success">' . e($status) . '</span>'
                        : ($status === '06'
                            ? '<span class="badge bg-danger">' . e($status) . '</span>'
                            : '<span class="badge bg-secondary">' . e($status ?: '-') . '</span>');
                    $desc = $log->status_desc ?? '-';
                    $isSuccess = stripos($log->status_desc ?? '', 'Success') !== false;
                    $descBadge = $isSuccess
                        ? '<span class="badge bg-success">' . e($desc) . '</span>'
                        : '<span class="badge bg-danger">' . e($desc) . '</span>';
                    return $statusBadge . ' ' . $descBadge;
                })
                ->editColumn('tanggal_callback', function ($log) {
                    return $log->tanggal_callback?->format('d/m/Y H:i') ?? '-';
                })
                ->editColumn('created_at', function ($log) {
                    return $log->created_at?->format('d/m/Y H:i');
                })
                ->rawColumns(['checkbox', 'status_info', 'action'])
                ->make(true);
        }

        $merchants = Merchant::orderBy('nama_merchant')->get(['id', 'nama_merchant', 'kode_merchant']);
        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('log-callbacks.index', compact('merchants', 'defaultDateFrom', 'defaultDateTo'));
    }

    public function show(LogCallback $logCallback): View
    {
        $logCallback->load('merchant:id,nama_merchant,kode_merchant');
        return view('log-callbacks.show', compact('logCallback'));
    }

    public function destroy(LogCallback $logCallback): RedirectResponse
    {
        $logCallback->delete();
        Alert::success('Berhasil', 'Log Callback berhasil dihapus.');
        return redirect()->route('log-callbacks.index');
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
            return redirect()->route('log-callbacks.index');
        }
        LogCallback::whereIn('id', $ids)->delete();
        Alert::success('Berhasil', count($ids) . ' log berhasil dihapus.');
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($ids) . ' log berhasil dihapus.']);
        }
        return redirect()->route('log-callbacks.index');
    }
}
