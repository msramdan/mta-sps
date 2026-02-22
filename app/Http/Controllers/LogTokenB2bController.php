<?php

namespace App\Http\Controllers;

use App\Models\LogTokenB2b;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            new Middleware(middleware: 'permission:log token b2b delete', only: ['destroy', 'bulkDestroy']),
        ];
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from', now()->startOfMonth()->format('Y-m-d'));
            $dateTo = request('date_to', now()->format('Y-m-d'));

            $query = LogTokenB2b::query()
                ->whereDate('created_at', '>=', $dateFrom)
                ->whereDate('created_at', '<=', $dateTo);

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
                ->addColumn('action', 'log-token-b2b.include.action')
                ->editColumn('created_at', function ($log) {
                    return $log->created_at?->format('d/m/Y H:i');
                })
                ->editColumn('processing_time', function ($log) {
                    return $log->processing_time ?? '-';
                })
                ->editColumn('is_success', function ($log) {
                    return $log->is_success === true
                        ? '<span class="badge bg-success">Sukses</span>'
                        : ($log->is_success === false
                            ? '<span class="badge bg-danger">Gagal</span>'
                            : '<span class="badge bg-secondary">-</span>');
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
                ->rawColumns(['checkbox', 'is_success', 'action'])
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
            return redirect()->route('log-token-b2b.index');
        }
        LogTokenB2b::whereIn('id', $ids)->delete();
        Alert::success('Berhasil', count($ids) . ' log berhasil dihapus.');
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($ids) . ' log berhasil dihapus.']);
        }
        return redirect()->route('log-token-b2b.index');
    }
}
