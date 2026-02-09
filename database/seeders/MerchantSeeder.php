<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil 1 bank untuk relasi (misal bank pertama)
        $bankId = DB::table('banks')->value('id');

        if (!$bankId) {
            // Kalau belum ada data bank, stop biar nggak error FK
            $this->command->warn('Seeder Merchant dilewati: data bank belum ada.');
            return;
        }

        DB::table('merchants')->insert([
            [
                'id' => (string) Str::uuid(),
                'nama_merchant' => 'Merchant Aktif Demo',
                'logo' => 'merchant-aktif.png',
                'url_callback' => 'https://merchant-aktif.test/callback',
                'apikey' => Str::random(32),
                'secretkey' => Str::random(64),
                'bank_id' => $bankId,
                'pemilik_rekening' => 'PT Merchant Aktif',
                'nomor_rekening' => '1234567890',
                'is_active' => 'Yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'nama_merchant' => 'Merchant Non Aktif Demo',
                'logo' => 'merchant-nonaktif.png',
                'url_callback' => 'https://merchant-nonaktif.test/callback',
                'apikey' => Str::random(32),
                'secretkey' => Str::random(64),
                'bank_id' => $bankId,
                'pemilik_rekening' => 'PT Merchant Non Aktif',
                'nomor_rekening' => '0987654321',
                'is_active' => 'No',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
