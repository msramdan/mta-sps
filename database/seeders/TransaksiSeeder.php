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
        $merchants = DB::table('merchants')->get();

        if ($merchants->isEmpty()) {
            $this->command->warn('Seeder Transaksi dilewati: data merchant belum ada.');
            return;
        }

        foreach ($merchants as $merchant) {
            // Generate unique reference numbers
            $noReferensi = 'REF' . now()->format('YmdHis') . Str::random(6);
            $noRefMerchant = 'MRCH' . now()->format('YmdHis') . Str::random(6);
            
            // Create transaksi
            $transaksiId = (string) Str::uuid();
            $tanggalTransaksi = now()->subHours(rand(1, 24));
            $biaya = rand(10000, 100000);
            $jumlahDibayar = $biaya;

            DB::table('transaksis')->insert([
                'id' => $transaksiId,
                'tanggal_transaksi' => $tanggalTransaksi,
                'merchant_id' => $merchant->id,
                'no_referensi' => $noReferensi,
                'no_ref_merchant' => $noRefMerchant,
                'nama_pelanggan' => 'Pelanggan ' . $merchant->nama_merchant,
                'email_pelanggan' => 'pelanggan' . Str::random(5) . '@example.com',
                'no_telpon_pelanggan' => '08' . rand(1000000000, 9999999999),
                'biaya' => $biaya,
                'jumlah_dibayar' => $jumlahDibayar,
                'status' => 'success',
                'created_at' => $tanggalTransaksi,
                'updated_at' => $tanggalTransaksi,
            ]);

            // Create log_generate_qrs
            $logGenerateQrId = (string) Str::uuid();
            $payloadGenerateQr = json_encode([
                'merchantId' => $merchant->nobu_merchant_id ?? '936005030000048891',
                'amount' => [
                    'value' => number_format($biaya, 2, '.', ''),
                    'currency' => 'IDR'
                ],
                'referenceNo' => $noReferensi,
                'partnerReferenceNo' => $noRefMerchant,
            ], JSON_PRETTY_PRINT);

            $responseGenerateQr = json_encode([
                'responseCode' => '00',
                'responseMessage' => 'Success',
                'qrCode' => 'https://qr.example.com/' . Str::random(20),
                'referenceNo' => $noReferensi,
            ], JSON_PRETTY_PRINT);

            DB::table('log_generate_qrs')->insert([
                'id' => $logGenerateQrId,
                'transaksi_id' => $transaksiId,
                'merchant_id' => $merchant->id,
                'payload_generate_qr' => $payloadGenerateQr,
                'response_generate_qr' => $responseGenerateQr,
                'is_success' => true,
                'created_at' => $tanggalTransaksi,
                'updated_at' => $tanggalTransaksi,
            ]);

            // Create log_callbacks - 1. Gagal (06 - Failed)
            $callbackGagalId = (string) Str::uuid();
            $tanggalCallbackGagal = $tanggalTransaksi->copy()->addMinutes(5);
            
            $payloadCallbackGagal = json_encode([
                'originalReferenceNo' => $noReferensi,
                'originalPartnerReferenceNo' => $noRefMerchant,
                'latestTransactionStatus' => '06',
                'transactionStatusDesc' => 'Failed',
                'amount' => [
                    'value' => number_format($biaya, 2, '.', ''),
                    'currency' => 'IDR'
                ],
                'externalStoreId' => $merchant->nobu_store_id ?? 'ID2020081400178',
                'additionalInfo' => [
                    'callbackUrl' => $merchant->url_callback ?? 'https://test.nobu.com/v1.0/qr/qr-mpm-notify',
                    'issuerId' => '93600503',
                    'merchantId' => $merchant->nobu_merchant_id ?? '936005030000048891',
                    'paymentDate' => $tanggalCallbackGagal->format('Y-m-d H:i:s'),
                ]
            ], JSON_PRETTY_PRINT);

            DB::table('log_callbacks')->insert([
                'id' => $callbackGagalId,
                'transaksi_id' => $transaksiId,
                'merchant_id' => $merchant->id,
                'payload_callback' => $payloadCallbackGagal,
                'tanggal_callback' => $tanggalCallbackGagal,
                'transaction_status' => '06',
                'status_desc' => 'Failed',
                'created_at' => $tanggalCallbackGagal,
                'updated_at' => $tanggalCallbackGagal,
            ]);

            // Create log_callbacks - 2. Berhasil (00 - Success)
            $callbackBerhasilId = (string) Str::uuid();
            $tanggalCallbackBerhasil = $tanggalTransaksi->copy()->addMinutes(10);
            
            $payloadCallbackBerhasil = json_encode([
                'originalReferenceNo' => $noReferensi,
                'originalPartnerReferenceNo' => $noRefMerchant,
                'latestTransactionStatus' => '00',
                'transactionStatusDesc' => 'Success',
                'amount' => [
                    'value' => number_format($biaya, 2, '.', ''),
                    'currency' => 'IDR'
                ],
                'externalStoreId' => $merchant->nobu_store_id ?? 'ID2020081400178',
                'additionalInfo' => [
                    'callbackUrl' => $merchant->url_callback ?? 'https://test.nobu.com/v1.0/qr/qr-mpm-notify',
                    'issuerId' => '93600503',
                    'merchantId' => $merchant->nobu_merchant_id ?? '936005030000048891',
                    'paymentDate' => $tanggalCallbackBerhasil->format('Y-m-d H:i:s'),
                    'retrievalReferenceNo' => 'MPMMVzeS' . time(),
                    'paymentReferenceNo' => '1010223071800002811170000489001'
                ]
            ], JSON_PRETTY_PRINT);

            DB::table('log_callbacks')->insert([
                'id' => $callbackBerhasilId,
                'transaksi_id' => $transaksiId,
                'merchant_id' => $merchant->id,
                'payload_callback' => $payloadCallbackBerhasil,
                'tanggal_callback' => $tanggalCallbackBerhasil,
                'transaction_status' => '00',
                'status_desc' => 'Success',
                'created_at' => $tanggalCallbackBerhasil,
                'updated_at' => $tanggalCallbackBerhasil,
            ]);
        }

        $this->command->info('Seeder Transaksi berhasil: ' . $merchants->count() . ' transaksi dibuat dengan log dan callback.');
    }
}
