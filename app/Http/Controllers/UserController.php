<?php

namespace App\Http\Controllers;

use App\Generators\Services\ImageServiceV2;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller implements HasMiddleware
{
    public function __construct(
        public ImageServiceV2 $imageServiceV2,
        public string $avatarPath = 'avatars',
        public string $disk = 's3'
    ) {
        //
    }

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:user view', only: ['index', 'show']),
            new Middleware(middleware: 'permission:user create', only: ['create', 'store']),
            new Middleware(middleware: 'permission:user edit', only: ['edit', 'update']),
            new Middleware(middleware: 'permission:user delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            $users = User::with(relations: ['roles:id,name', 'assignedMerchants'])->orderByDesc('created_at');

            return Datatables::of(source: $users)
                ->addColumn(name: 'avatar', content: fn($row) => $row->avatar)
                ->addColumn(name: 'action', content: 'users.include.action')
                ->addColumn(name: 'role', content: fn($row) => $row->getRoleNames()->toArray() !== [] ? $row->getRoleNames()[0] : '-')
                ->addColumn(name: 'merchants', content: fn($row) => $row->assignedMerchants->pluck('nama_merchant')->implode(', ') ?: '-')
                ->toJson();
        }

        return view(view: 'users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();
        $merchants = Merchant::orderBy('nama_merchant')->get();

        return view(view: 'users.create', data: compact('roles', 'merchants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        return DB::transaction(callback: function () use ($request): RedirectResponse {
            $validated = $request->validated();
            $validated['avatar'] = $this->imageServiceV2->upload(
                name: 'avatar',
                path: $this->avatarPath,
                defaultImage: null,
                disk: $this->disk
            );
            $validated['password'] = bcrypt(value: $request->password);
            $validated['log_otp'] = ($request->log_otp ?? 'No') === 'Yes' ? 'Yes' : 'No';

            $user = User::create(attributes: $validated);

            $role = Role::select(columns: ['id', 'name'])->find(id: $request->role);
            $user->assignRole(roles: $role->name);

            // Assign merchants to user jika ada
            if ($request->has('merchants') && is_array($request->merchants)) {
                foreach ($request->merchants as $merchantId) {
                    DB::table('assign_merchants')->insert([
                        'user_id' => $user->id,
                        'merchant_id' => $merchantId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            Alert::success('Berhasil', 'User berhasil dibuat.');
            return redirect()->route('users.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->load(relations: ['roles:id,name', 'assignedMerchants']);

        return view(view: 'users.show', data: compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $user->load(relations: ['roles:id,name', 'assignedMerchants']);
        $roles = Role::all();
        $merchants = Merchant::orderBy('nama_merchant')->get();

        // Get assigned merchant IDs
        $assignedMerchantIds = $user->assignedMerchants->pluck('id')->toArray();

        return view(view: 'users.edit', data: compact('user', 'roles', 'merchants', 'assignedMerchantIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        return DB::transaction(callback: function () use ($request, $user): RedirectResponse {
            $validated = $request->validated();

            // Tidak ada upload gambar → skip, tetap pakai avatar lama
            // Ada upload gambar baru → upload ke RustFS dan replace (hapus file lama)
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $validated['avatar'] = $this->imageServiceV2->upload(
                    name: 'avatar',
                    path: $this->avatarPath,
                    defaultImage: $user->getRawOriginal('avatar'),
                    disk: $this->disk
                );
            } else {
                $validated['avatar'] = $user->getRawOriginal('avatar');
            }

            $validated['log_otp'] = ($request->log_otp ?? 'No') === 'Yes' ? 'Yes' : 'No';

            if (! $request->password) {
                unset($validated['password']);
            } else {
                $validated['password'] = bcrypt(value: $request->password);
            }

            $user->update(attributes: $validated);

            $role = Role::select(columns: ['id', 'name'])->find(id: $request->role);
            $user->syncRoles(roles: $role->name);

            // Update merchant assignments
            DB::table('assign_merchants')->where('user_id', $user->id)->delete();

            if ($request->has('merchants') && is_array($request->merchants)) {
                foreach ($request->merchants as $merchantId) {
                    DB::table('assign_merchants')->insert([
                        'user_id' => $user->id,
                        'merchant_id' => $merchantId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            Alert::success('Berhasil', 'User berhasil diperbarui.');
            return redirect()->route('users.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            return DB::transaction(callback: function () use ($user): RedirectResponse {
                $avatar = $user->getRawOriginal('avatar');

                // Delete merchant assignments first
                DB::table('assign_merchants')->where('user_id', $user->id)->delete();

                $user->delete();

                $this->imageServiceV2->delete(path: $this->avatarPath, image: $avatar, disk: $this->disk);

                Alert::success('Berhasil', 'User berhasil dihapus.');
                return redirect()->route('users.index');
            });
        } catch (\Exception $e) {
            Alert::error('Gagal', 'User tidak dapat dihapus karena terkait dengan tabel lain.');
            return redirect()->route('users.index');
        }
    }
}
