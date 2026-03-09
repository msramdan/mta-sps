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
        'Administrasi',
        'Super Admin',
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

        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        // SPH & SPK: Super Admin & Administrasi
        $administrasi = Role::where('name', 'Administrasi')->first();
        if ($administrasi) {
            $administrasi->givePermissionTo([
                'sph view', 'sph create', 'sph edit', 'sph delete',
                'spk view', 'spk create', 'spk edit', 'spk delete',
            ]);
        }

        // SPK: Finance view only (untuk proses penagihan nanti)
        $financeRole = Role::where('name', 'Finance')->first();
        if ($financeRole) {
            $financeRole->givePermissionTo(['spk view']);
        }

        // SPK: Manager Teknik view (referensi ke Jadwal)
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        if ($managerTeknikRole) {
            $managerTeknikRole->givePermissionTo(['spk view']);
        }

        // Jadwal Teknisi: full akses hanya Manager Teknik & Super Admin; lainnya view only
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        if ($managerTeknikRole) {
            $managerTeknikRole->givePermissionTo([
                'jadwal teknisi view',
                'jadwal teknisi create',
                'jadwal teknisi edit',
                'jadwal teknisi delete',
            ]);
        }

        $administrasi = Role::where('name', 'Administrasi')->first();
        if ($administrasi) {
            $administrasi->givePermissionTo([
                'jadwal teknisi view',
            ]);
        }

        // Kunjungan Sales: create, edit, delete hanya Sales Marketing & Super Admin; lainnya view only
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

        // Working: Teknisi input progress; others view only
        $teknisRole = Role::where('name', 'Teknisi')->first();
        if ($teknisRole) {
            $teknisRole->givePermissionTo(['working view', 'working create']);
        }
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        if ($managerTeknikRole) {
            $managerTeknikRole->givePermissionTo(['working view']);
        }
        $financeRole = Role::where('name', 'Finance')->first();
        if ($financeRole) {
            $financeRole->givePermissionTo(['working view']);
        }
        $administrasi = Role::where('name', 'Administrasi')->first();
        if ($administrasi) {
            $administrasi->givePermissionTo(['working view']);
        }
        $salesRole = Role::where('name', 'Sales Marketing')->first();
        if ($salesRole) {
            $salesRole->givePermissionTo(['working view']);
        }

        // Penagihan: Finance & Administrasi full; others view only
        $financeRole = Role::where('name', 'Finance')->first();
        if ($financeRole) {
            $financeRole->givePermissionTo(['penagihan view', 'penagihan create', 'penagihan edit']);
        }
        $administrasi = Role::where('name', 'Administrasi')->first();
        if ($administrasi) {
            $administrasi->givePermissionTo(['penagihan view', 'penagihan create', 'penagihan edit']);
        }
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        if ($managerTeknikRole) {
            $managerTeknikRole->givePermissionTo(['penagihan view']);
        }
        $salesRole = Role::where('name', 'Sales Marketing')->first();
        if ($salesRole) {
            $salesRole->givePermissionTo(['penagihan view']);
        }
        $teknisRole = Role::where('name', 'Teknisi')->first();
        if ($teknisRole) {
            $teknisRole->givePermissionTo(['penagihan view']);
        }

        $firstUser = User::first();
        if ($firstUser && $superAdmin) {
            $firstUser->syncRoles([$superAdmin]);
        }

        $this->assignUserRoles();
    }

    /**
     * Assign roles to users based on email.
     */
    protected function assignUserRoles(): void
    {
        $salesMarketing = Role::where('name', 'Sales Marketing')->first();
        $teknisRole = Role::where('name', 'Teknisi')->first();
        $financeRole = Role::where('name', 'Finance')->first();
        $managerTeknikRole = Role::where('name', 'Manager Teknik')->first();
        $administrasi = Role::where('name', 'Administrasi')->first();

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $roleMap = [
            'admin@example.com' => [$superAdminRole],
            'udin.wahidin@mta.local' => [$salesMarketing],
            'anne.putri.rifana@mta.local' => [$salesMarketing],
            'riyan.hendryana@mta.local' => [$salesMarketing, $managerTeknikRole],
            'yudi.susanto@mta.local' => [$salesMarketing],
            'andri.febriana@mta.local' => [$teknisRole],
            'niken@mta.local' => [$teknisRole],
            'rere@mta.local' => [$teknisRole],
            'leli@mta.local' => [$teknisRole],
            'eka.agustina.rahayu@mta.local' => [$financeRole],
            'ria.fitriani@mta.local' => [$administrasi],
        ];

        foreach ($roleMap as $email => $roles) {
            $roles = array_filter($roles);
            if (empty($roles)) {
                continue;
            }
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->syncRoles($roles);
            }
        }
    }
}
