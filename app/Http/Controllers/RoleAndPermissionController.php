<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleAndPermissionController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'permission:role & permission view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:role & permission create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:role & permission edit', only: ['edit', 'store']),
            new Middleware(middleware: 'permission:role & permission delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $users = Role::query()->orderByDesc('created_at');

            return DataTables::of(source: $users)
                ->addColumn(name: 'created_at', content: fn ($row) => $row->created_at->format('Y-m-d H:i:s'))
                ->addColumn(name: 'updated_at', content: fn ($row) => $row->updated_at->format('Y-m-d H:i:s'))
                ->addColumn(name: 'action', content: 'roles.include.action')
                ->toJson();
        }

        return view(view: 'roles.index');
    }

    /**
     * Show the form for creating a new resource.
     * Disabled: role tetap (fixed), create disembunyikan.
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * Disabled: role tetap (fixed), create disembunyikan.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $role = Role::with(relations: ['permissions'])->findOrFail(id: $id);

        return view(view: 'roles.show', data: compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $role = Role::with(relations: ['permissions'])->findOrFail(id: $id);

        return view(view: 'roles.edit', data: compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id): RedirectResponse
    {
        return DB::transaction(callback: function () use ($request, $id): RedirectResponse {
            $role = Role::with('permissions')->findOrFail(id: $id);
            $oldName = $role->name;
            $oldPermissions = $role->permissions->pluck('name')->toArray();
            $role->update(attributes: ['name' => $request->name]);
            $role->syncPermissions(permissions: $request->permissions);

            ActivityLogHelper::log(
                description: 'Role updated',
                logName: 'role',
                properties: [
                    'before' => ['name' => $oldName, 'permissions' => $oldPermissions],
                    'after' => ['name' => $role->name, 'permissions' => $request->permissions],
                ],
                subject: $role
            );

            return to_route(route: 'roles.index')->with(key: 'success', value: __(key: 'The role was updated successfully.'));
        });
    }

    /**
     * Remove the specified resource from storage.
     * Disabled: role tetap (fixed), delete disembunyikan.
     */
    public function destroy(string $id): RedirectResponse
    {
        abort(404);
    }
}
