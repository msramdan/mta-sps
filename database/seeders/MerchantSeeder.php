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
        $bankId = DB::table('banks')->value('id');

        if (! $bankId) {
            $this->command->warn('Seeder Merchant dilewati: data bank belum ada.');
            return;
        }

        // Generate UUID merchant
        $merchantId = (string) Str::uuid();

        // Insert merchant
        DB::table('merchants')->insert([
            'id' => $merchantId,
            'nama_merchant' => 'Tecanusa',
            'logo' => 'merchant-aktif.png',
            'url_callback' => 'https://merchant-aktif.test/callback',
            'apikey' => Str::random(32),
            'secretkey' => Str::random(64),
            'bank_id' => $bankId,
            'pemilik_rekening' => 'Muhammad Saeful Ramdan',
            'nomor_rekening' => '1234567890',
            'is_active' => 'Yes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert assign_merchants
        DB::table('assign_merchants')->insert([
            'user_id' => 1,
            'merchant_id' => $merchantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
