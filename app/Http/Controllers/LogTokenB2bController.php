<?php

namespace App\Http\Controllers;

use App\Models\LogTokenB2b;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LogTokenB2bController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:log token b2b view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:log token b2b delete', only: ['destroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogTokenB2b::query()
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo)
                ->latest();

            return DataTables::of($query)
                ->addColumn('action', 'log-token-b2b.include.action')
                ->editColumn('created_at', function ($log) {
                    return $log->created_at?->format('d/m/Y H:i');
                })
                ->editColumn('header', function ($log) {
                    if (!$log->header) return '-';
                    return strlen($log->header) > 80 ? substr($log->header, 0, 80) . '...' : $log->header;
                })
                ->editColumn('payload', function ($log) {
                    if (!$log->payload) return '-';
                    return strlen($log->payload) > 80 ? substr($log->payload, 0, 80) . '...' : $log->payload;
                })
                ->editColumn('response', function ($log) {
                    if (!$log->response) return '-';
                    return strlen($log->response) > 80 ? substr($log->response, 0, 80) . '...' : $log->response;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('log-token-b2b.index', compact('defaultDateFrom', 'defaultDateTo'));
    }

    public function show(LogTokenB2b $logTokenB2b): View
    {
        return view('log-token-b2b.show', compact('logTokenB2b'));
    }

    public function destroy(LogTokenB2b $logTokenB2b): RedirectResponse
    {
        $logTokenB2b->delete();
        Alert::success('Berhasil', 'Log Token B2B berhasil dihapus.');
        return redirect()->route('log-token-b2b.index');
    }
}
