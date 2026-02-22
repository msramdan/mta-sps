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

        $transaksis = [
            [
                'label' => 'Charge to Merchant',
                'jumlah_dibayar' => 10000,
                'biaya' => 570,   // 0.7% x 10k + 500
                'jumlah_diterima' => 9430,  // 10k - 570
                'beban_biaya' => 'Merchant',
                'nama' => 'Pelanggan A',
            ],
            [
                'label' => 'Charge to Pelanggan',
                'jumlah_diterima' => 10000,
                'biaya' => 574,   // 0.7% x 10.574 + 500
                'jumlah_dibayar' => 10574,  // (10k + 500) / 0.993
                'beban_biaya' => 'Pelanggan',
                'nama' => 'Pelanggan B',
            ],
        ];

        foreach ($transaksis as $i => $data) {
            $noReferensi = 'REF' . now()->format('YmdHis') . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
            $noRefMerchant = 'MRCH' . now()->format('YmdHis') . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);

            $transaksiId = (string) Str::uuid();
            $tanggalTransaksi = now()->subHours($i + 1);

            DB::table('transaksis')->insert([
                'id' => $transaksiId,
                'tanggal_transaksi' => $tanggalTransaksi,
                'merchant_id' => $merchant->id,
                'no_referensi' => $noReferensi,
                'no_ref_merchant' => $noRefMerchant,
                'nama_pelanggan' => $data['nama'],
                'email_pelanggan' => 'pelanggan' . ($i + 1) . '@example.com',
                'no_telpon_pelanggan' => '0800000000' . ($i + 1),
                'biaya' => $data['biaya'],
                'jumlah_dibayar' => $data['jumlah_dibayar'],
                'jumlah_diterima' => $data['jumlah_diterima'],
                'beban_biaya' => $data['beban_biaya'],
                'status' => 'success',
                'created_at' => $tanggalTransaksi,
                'updated_at' => $tanggalTransaksi,
            ]);
        }

        $this->command->info('Seeder Transaksi berhasil: 2 transaksi dibuat (charge to merchant & charge to pelanggan).');
    }
}
