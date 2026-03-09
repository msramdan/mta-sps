<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    protected string $defaultPassword = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'no_wa' => '6283874731480',
            ],
            // Sales Marketing
            ['name' => 'Udin Wahidin', 'email' => 'udin.wahidin@mta.local', 'no_wa' => '6280000000001'],
            ['name' => 'Anne Putri Rifana', 'email' => 'anne.putri.rifana@mta.local', 'no_wa' => '6280000000002'],
            ['name' => 'Riyan Hendryana', 'email' => 'riyan.hendryana@mta.local', 'no_wa' => '6280000000003'],
            ['name' => 'Yudi Susanto', 'email' => 'yudi.susanto@mta.local', 'no_wa' => '6280000000004'],
            // Teknisi
            ['name' => 'Andri Febriana', 'email' => 'andri.febriana@mta.local', 'no_wa' => '6280000000005'],
            ['name' => 'Niken', 'email' => 'niken@mta.local', 'no_wa' => '6280000000006'],
            ['name' => 'Rere', 'email' => 'rere@mta.local', 'no_wa' => '6280000000007'],
            ['name' => 'Leli', 'email' => 'leli@mta.local', 'no_wa' => '6280000000008'],
            // Finance
            ['name' => 'Eka Agustina Rahayu', 'email' => 'eka.agustina.rahayu@mta.local', 'no_wa' => '6280000000009'],
            // Manager Teknik (Riyan Hendryana - sudah di Sales Marketing)
            // Administrasi
            ['name' => 'Ria Fitriani', 'email' => 'ria.fitriani@mta.local', 'no_wa' => '6280000000010'],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'no_wa' => $data['no_wa'],
                    'email_verified_at' => now(),
                    'password' => $this->defaultPassword,
                    'remember_token' => Str::random(10),
                ]
            );
        }
    }
}
