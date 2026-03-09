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

        // Kunjungan Sales: create, edit, delete hanya Sales Marketing & Admin; lainnya view only
        $kunjunganPermissions = ['kunjungan sales view', 'kunjungan sales create', 'kunjungan sales edit', 'kunjungan sales delete'];
        $salesRole = Role::where('name', 'Sales Marketing')->first();
        if ($salesRole) {
            $salesRole->givePermissionTo($kunjunganPermissions);
        }
        $teknisRole = Role::where('name', 'Teknisi')->first();
        if ($teknisRole) {
            $teknisRole->givePermissionTo(['kunjungan sales view']);
        }
        $financeRole = Role::where('name', 'Finance')->first();
        if ($financeRole) {
            $financeRole->givePermissionTo(['kunjungan sales view']);
        }
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        if ($managerTeknikRole) {
            $managerTeknikRole->givePermissionTo(['kunjungan sales view']);
        }

        // SPH: hanya Admin (via Permission::all() di atas)
        // Tidak perlu assign ke role lain - Admin saja

        $firstUser = User::first();
        if ($firstUser && $admin) {
            $firstUser->syncRoles([$admin]);
        }
    }
}
