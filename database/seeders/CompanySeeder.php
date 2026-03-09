<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::firstOrCreate(['name' => 'PT. Mitra Tera Akurasi']);
        Company::firstOrCreate(['name' => 'Dummy Perusahaan']);

        // Assign admin (user id 1) ke kedua perusahaan
        $admin = User::find(1);
        if ($admin) {
            $admin->companies()->sync(Company::pluck('id')->toArray());
        }
    }
}
