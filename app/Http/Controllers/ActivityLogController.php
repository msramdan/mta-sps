<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:activity log view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:activity log delete', only: ['destroy', 'bulkDestroy', 'truncate']),
        ];
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Activity::with(['causer:id,name,email', 'subject'])
                ->orderByDesc('created_at');

            if ($request->filled('log_name')) {
                $query->where('log_name', $request->log_name);
            }

            if ($request->filled('causer_id')) {
                $query->where('causer_id', $request->causer_id);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('description')) {
                $query->where('description', 'like', '%' . $request->description . '%');
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function ($activity) {
                    return '<input type="checkbox" class="form-check-input log-row-checkbox" value="' . $activity->id . '">';
                })
                ->addColumn('action', 'activity-logs.include.action')
                ->editColumn('causer_id', fn ($activity) => $activity->causer ? $activity->causer->name . ' (' . $activity->causer->email . ')' : '-')
                ->editColumn('subject_type', fn ($activity) => $activity->subject_type ? class_basename($activity->subject_type) : '-')
                ->editColumn('event', fn ($activity) => $activity->event ? '<span class="badge bg-info">' . $activity->event . '</span>' : '-')
                ->editColumn('created_at', fn ($activity) => $activity->created_at?->format('d/m/Y H:i:s'))
                ->rawColumns(['checkbox', 'action', 'event'])
                ->make(true);
        }

        $logNames = Activity::distinct()->pluck('log_name')->filter()->values();
        $defaultDateFrom = now()->startOfMonth()->format('Y-m-d');
        $defaultDateTo = now()->format('Y-m-d');

        return view('activity-logs.index', compact('logNames', 'defaultDateFrom', 'defaultDateTo'));
    }

    public function show(Activity $activityLog): View
    {
        $activityLog->load(['causer:id,name,email', 'subject']);

        $properties = $activityLog->properties;
        $propertiesFormatted = ActivityLogHelper::formatPropertiesForDisplay(
            $properties ? $properties->toArray() : []
        );

        return view('activity-logs.show', compact('activityLog', 'propertiesFormatted'));
    }

    public function destroy(Activity $activityLog): RedirectResponse
    {
        $activityLog->delete();
        Alert::success('Berhasil', 'Activity log berhasil dihapus.');
        return redirect()->route('activity-logs.index');
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
            return redirect()->route('activity-logs.index');
        }
        Activity::whereIn('id', $ids)->delete();
        Alert::success('Berhasil', count($ids) . ' activity log berhasil dihapus.');
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => count($ids) . ' activity log berhasil dihapus.']);
        }
        return redirect()->route('activity-logs.index');
    }

    public function truncate(): RedirectResponse
    {
        Activity::query()->delete();
        Alert::success('Berhasil', 'Semua data Activity Log telah dikosongkan.');
        return redirect()->route('activity-logs.index');
    }
}
