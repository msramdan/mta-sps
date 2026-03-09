<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Role tetap (fixed) - tidak ada create/delete dari UI.
     */
    protected array $fixedRoles = [
        'Sales Marketing',
        'Teknisi',
        'Finance',
        'Manager Teknik',
        'Admin',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::firstOrCreate(['name' => $access]);
            }
        }

        foreach ($this->fixedRoles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->givePermissionTo(Permission::all());
        }

        $firstUser = User::first();
        if ($firstUser && $admin) {
            $firstUser->syncRoles([$admin]);
        }
    }
}
