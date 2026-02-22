<?php

namespace App\Http\Controllers;

use App\Models\LogQueryPaymentStatus;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class LogQueryPaymentStatusController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:log query payment status view', only: ['index', 'show']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogQueryPaymentStatus::with('merchant:id,nama_merchant,kode_merchant')
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
                ->addColumn('action', 'log-query-payment-status.include.action')
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
                ->rawColumns(['is_success', 'action'])
                ->make(true);
        }

        $merchants = Merchant::orderBy('nama_merchant')->get(['id', 'nama_merchant', 'kode_merchant']);
        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('log-query-payment-status.index', compact('merchants', 'defaultDateFrom', 'defaultDateTo'));
    }

    public function show(LogQueryPaymentStatus $logQueryPaymentStatus): View
    {
        $logQueryPaymentStatus->load('merchant:id,nama_merchant,kode_merchant');
        return view('log-query-payment-status.show', compact('logQueryPaymentStatus'));
    }
}
