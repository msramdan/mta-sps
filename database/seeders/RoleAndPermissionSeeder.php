<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::firstOrCreate(['name' => 'admin']);
        $userMerchant = Role::firstOrCreate(['name' => 'User Merchant']);

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::firstOrCreate(['name' => $access]);
            }
        }

        $userAdmin = User::first();
        $userAdmin->assignRole('admin');
        $superAdmin->givePermissionTo(Permission::all());

        // TAMBAHKAN PERMISSION KHUSUS UNTUK USER MERCHANT (tanpa force resend callback)
        $merchantPermissions = [
            'setting merchant',
            'tarik saldo view',
            'pengajuan tarik saldo',
            'batalkan tarik saldo',
            'transaksi view',
            'resend callback',
        ];

        // Berikan permission hanya yang diperlukan untuk User Merchant
        foreach ($merchantPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $userMerchant->givePermissionTo($permission);
            }
        }
    }
}
