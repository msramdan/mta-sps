<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = DB::table('merchants')->first();

        if (!$merchant) {
            $this->command->warn('Seeder Transaksi dilewati: data merchant belum ada.');
            return;
        }

        $merchantId = $merchant->id;
        $kodeMerchant = $merchant->kode_merchant;

        // Sample transaksi 1 - Success
        DB::table('transaksis')->insert([
            'id' => (string) Str::uuid(),
            'tanggal_transaksi' => now()->subHours(2),
            'merchant_id' => $merchantId,
            'no_referensi' => $kodeMerchant . '-' . now()->subHours(2)->format('ymd') . '-123001',
            'no_ref_merchant' => 'MERCHANT-REF-001',
            'nama_pelanggan' => 'John Doe',
            'email_pelanggan' => 'john.doe@example.com',
            'no_telpon_pelanggan' => '081234567890',
            'biaya' => 100000.00,
            'jumlah_dibayar' => 100000.00,
            'status' => 'success',
            'payload_generate_qr' => json_encode([
                'merchant_id' => $merchantId,
                'amount' => 100000,
                'customer_name' => 'John Doe',
            ]),
            'callback' => json_encode([
                'status' => 'success',
                'transaction_id' => $kodeMerchant . '-' . now()->subHours(2)->format('ymd') . '-123001',
                'message' => 'Payment successful',
            ]),
            'tanggal_callback' => now()->subHours(1)->subMinutes(30),
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(1)->subMinutes(30),
        ]);

        // Sample transaksi 2 - Pending
        DB::table('transaksis')->insert([
            'id' => (string) Str::uuid(),
            'tanggal_transaksi' => now()->subMinutes(30),
            'merchant_id' => $merchantId,
            'no_referensi' => $kodeMerchant . '-' . now()->subMinutes(30)->format('ymd') . '-456002',
            'no_ref_merchant' => 'MERCHANT-REF-002',
            'nama_pelanggan' => 'Jane Smith',
            'email_pelanggan' => 'jane.smith@example.com',
            'no_telpon_pelanggan' => '082345678901',
            'biaya' => 250000.00,
            'jumlah_dibayar' => 0.00,
            'status' => 'pending',
            'payload_generate_qr' => json_encode([
                'merchant_id' => $merchantId,
                'amount' => 250000,
                'customer_name' => 'Jane Smith',
            ]),
            'callback' => null,
            'tanggal_callback' => null,
            'created_at' => now()->subMinutes(30),
            'updated_at' => now()->subMinutes(30),
        ]);

        // Sample transaksi 3 - Failed
        DB::table('transaksis')->insert([
            'id' => (string) Str::uuid(),
            'tanggal_transaksi' => now()->subDays(1),
            'merchant_id' => $merchantId,
            'no_referensi' => $kodeMerchant . '-' . now()->subDays(1)->format('ymd') . '-789003',
            'no_ref_merchant' => null,
            'nama_pelanggan' => 'Bob Wilson',
            'email_pelanggan' => null,
            'no_telpon_pelanggan' => '083456789012',
            'biaya' => 50000.00,
            'jumlah_dibayar' => 0.00,
            'status' => 'failed',
            'payload_generate_qr' => json_encode([
                'merchant_id' => $merchantId,
                'amount' => 50000,
                'customer_name' => 'Bob Wilson',
            ]),
            'callback' => json_encode([
                'status' => 'failed',
                'transaction_id' => $kodeMerchant . '-' . now()->subDays(1)->format('ymd') . '-789003',
                'message' => 'Insufficient balance',
            ]),
            'tanggal_callback' => now()->subDays(1)->addMinutes(5),
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1)->addMinutes(5),
        ]);

        $this->command->info('Seeder Transaksi berhasil: 3 transaksi sample dibuat.');
    }
}
