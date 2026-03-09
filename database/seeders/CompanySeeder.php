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

        $companyIds = Company::pluck('id')->toArray();

        // Assign semua user ke PT. Mitra Tera Akurasi (minimal 1 company agar bisa login)
        User::all()->each(function (User $user) use ($companyIds) {
            if ($user->companies()->count() === 0) {
                $user->companies()->sync($companyIds);
            }
        });
    }
}
