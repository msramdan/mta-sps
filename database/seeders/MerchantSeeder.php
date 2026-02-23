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

        // ========== MERCHANT 1: BILLINGHUB PRIMARY ==========
        $merchantId1 = (string) Str::uuid();

        DB::table('merchants')->insert([
            'id' => $merchantId1,
            'kode_merchant' => 'QR000001',
            'nama_merchant' => 'Billinghub Primary',
            'logo' => 'merchant-aktif.png',
            'url_callback' => 'https://billinghub.id/callback-qrin',
            'token_qrin' => Str::random(64),

            // === KONFIGURASI NOBU (DATA SAMPEL) ===
            'nobu_client_id' => '3783c5ca-ae59-4107-a007-2bd99d6e8bb4',
            'nobu_partner_id' => '3783c5caae594107a0072bd99d6e8bb4',
            'nobu_client_secret' => 'a01c45c7-35ce-4540-a748-f4ce2e165b6d',
            'nobu_private_key' => 'MIIEpAIBAAKCAQEAq15pw8ElOjFhgSXFEIojrzuO06XxKPJMwR6Lnk4wfT9LmdKHWnWfA4C9gkUFYVO9+gDsYkCjnnj7iy+WNq0MuzPIAW59Gyxf0VxWEaTzHwV0sR2zO8ikp9kBGdUSQvZkQ0Jj/TAlaOUspEnOcdTDjvLWbXYHTOHT37H00Ltgw6obx+zg6eRaE9hP82WzeuudjY8WbG0gqwCKVB0rXDEm5fiORPjuNI1qHZ9R0mOBtYUuTuyeLhy9bQsdEp6bdgmNEbsDtLWOTAaht2CYDmxSOnXkemdLjdAm4yqw2ECeMC9OCYlIqATtOsqZtKfUIbVUsUCFD/GF8FrD3//r81raBQIDAQABAoIBAFW668pki80q+w5y6L03flahwvga4iSL4t4R++L8VsGxso6HhfM5OI22EBhlkyV3kWjKoXcdwzz6ZUziR5GezOmyI/KjZa78agsA2IYHMSFpx1D7/LiBze2yYByePX6GaO5E/mShe3WYgNbHnaHQwOx4i9FC5LAPocEc886gju4TEC5zPPflISdmrhwENQtqfeINd1CE9gzKYd5z6CuY16YCFL+a6TLSrMEd4Z8Nr4W7lIDdFB1vhP+37rSvwcuHAkw2yLl5yOgNe7FM9muQPtyLzQKVaWbMaX2O5ZLK9cIrGDz1n0Dmo3iAc5x3tog8sRMaBuOkSosnI3GadNiXPwECgYEA1OFzD/ZZ0bhH+j4HS7L8zx29li7Ym3IWi7jMJdpOf2CsCl453ca+pAIPkfC4fRO1xP+2G2AJvgeNvsvbK1QUvUdGsXaAxO3vfld4SJjPQ5w9PCVTO/TWGnOcEkb/3bAR2ONFcLcYWWLf9pN2SLtHGJAQ5yAhzdAVbAfMuaytleECgYEAzhRwg2wtX1xEkVeW9bS6bzQfMpSHveFxbj3ymYoPernlqNotg0owCUaIb28cg4UhPVSCmiXDZbif0JVzcmsQ7DAD4C26Fduos2oVkadAvr/emeJXWioSBHy7/ex228oFW7m7YrRdTz9IQb0M+ormqJJZgBCsvKy+Oab2UfAhQKUCgYAWVOw4IXS8rmNGmhkz1Lv2kj0gMxvf+rDoyWMJGYSgkiiaEdZqMH4xQFIX0jPYUyf/WX/mEUYUXEB/Ym1Ed1aRoJeG6FKL1hYIn+5rVzRu+EXoOFYp9P482iHmPPJ8dAr7QKQ5NcvlHJ04BbIj4RmNNxe+1z0UlR6aLZtJYxb2oQKBgQCaco0kogWbS46EE04rVcjIIRskkFbvgy+8/KZ+Vg9l3j71/pZPqGE6AmeshGytUTBpQ5YiKx03dlgoPmnonb9wFEhDUmH9kcPsuxvxLpWCoFAXqp/nDlK0lDtcgkVOUikT5q4+uoiYJQhlZGd+um1Gd3CmX1jmityCXtSK8loplQKBgQCT2sqA2vw9z9vhfJmdxfPG6lI77HTHtEhhhL7bZ8HaUX1fp4olQ4jT4NdnkgSM0lMHuTdH4PV6E4SM2QDtVKalgPkmrq4K5Axsn5tB2R8hNvG+dZeuk0pjI/xLXWHb3mTmNQXBqvFokHtV/R5Gcb3qhbL2ZjafB+22rKGZgKGJeg==',
            'nobu_merchant_id' => '936005030000078300',
            'nobu_sub_merchant_id' => '26020900000005',
            'nobu_store_id' => 'ID2026020900005',
            // ======================================

            'bank_id' => $bankId,
            'pemilik_rekening' => 'Muhammad Saeful Ramdan',
            'nomor_rekening' => '1234567890',
            'ktp' => 'ktp-sample.png',
            'catatan' => 'Merchant Billinghub Primary untuk callback QRIN.',
            'status' => 'approved',
            'beban_biaya' => 'Merchant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ========== MERCHANT 2: BILLINGHUB CLIENT ==========
        $merchantId2 = (string) Str::uuid();

        DB::table('merchants')->insert([
            'id' => $merchantId2,
            'kode_merchant' => 'QR000002',
            'nama_merchant' => 'Billinghub Client',
            'logo' => 'merchant-aktif.png',
            'url_callback' => 'https://billinghub.id/handle-qrin',
            'token_qrin' => Str::random(64),

            // === KONFIGURASI NOBU (DATA SAMPEL) ===
            'nobu_client_id' => '3783c5ca-ae59-4107-a007-2bd99d6e8bb4',
            'nobu_partner_id' => '3783c5caae594107a0072bd99d6e8bb4',
            'nobu_client_secret' => 'a01c45c7-35ce-4540-a748-f4ce2e165b6d',
            'nobu_private_key' => 'MIIEpAIBAAKCAQEAq15pw8ElOjFhgSXFEIojrzuO06XxKPJMwR6Lnk4wfT9LmdKHWnWfA4C9gkUFYVO9+gDsYkCjnnj7iy+WNq0MuzPIAW59Gyxf0VxWEaTzHwV0sR2zO8ikp9kBGdUSQvZkQ0Jj/TAlaOUspEnOcdTDjvLWbXYHTOHT37H00Ltgw6obx+zg6eRaE9hP82WzeuudjY8WbG0gqwCKVB0rXDEm5fiORPjuNI1qHZ9R0mOBtYUuTuyeLhy9bQsdEp6bdgmNEbsDtLWOTAaht2CYDmxSOnXkemdLjdAm4yqw2ECeMC9OCYlIqATtOsqZtKfUIbVUsUCFD/GF8FrD3//r81raBQIDAQABAoIBAFW668pki80q+w5y6L03flahwvga4iSL4t4R++L8VsGxso6HhfM5OI22EBhlkyV3kWjKoXcdwzz6ZUziR5GezOmyI/KjZa78agsA2IYHMSFpx1D7/LiBze2yYByePX6GaO5E/mShe3WYgNbHnaHQwOx4i9FC5LAPocEc886gju4TEC5zPPflISdmrhwENQtqfeINd1CE9gzKYd5z6CuY16YCFL+a6TLSrMEd4Z8Nr4W7lIDdFB1vhP+37rSvwcuHAkw2yLl5yOgNe7FM9muQPtyLzQKVaWbMaX2O5ZLK9cIrGDz1n0Dmo3iAc5x3tog8sRMaBuOkSosnI3GadNiXPwECgYEA1OFzD/ZZ0bhH+j4HS7L8zx29li7Ym3IWi7jMJdpOf2CsCl453ca+pAIPkfC4fRO1xP+2G2AJvgeNvsvbK1QUvUdGsXaAxO3vfld4SJjPQ5w9PCVTO/TWGnOcEkb/3bAR2ONFcLcYWWLf9pN2SLtHGJAQ5yAhzdAVbAfMuaytleECgYEAzhRwg2wtX1xEkVeW9bS6bzQfMpSHveFxbj3ymYoPernlqNotg0owCUaIb28cg4UhPVSCmiXDZbif0JVzcmsQ7DAD4C26Fduos2oVkadAvr/emeJXWioSBHy7/ex228oFW7m7YrRdTz9IQb0M+ormqJJZgBCsvKy+Oab2UfAhQKUCgYAWVOw4IXS8rmNGmhkz1Lv2kj0gMxvf+rDoyWMJGYSgkiiaEdZqMH4xQFIX0jPYUyf/WX/mEUYUXEB/Ym1Ed1aRoJeG6FKL1hYIn+5rVzRu+EXoOFYp9P482iHmPPJ8dAr7QKQ5NcvlHJ04BbIj4RmNNxe+1z0UlR6aLZtJYxb2oQKBgQCaco0kogWbS46EE04rVcjIIRskkFbvgy+8/KZ+Vg9l3j71/pZPqGE6AmeshGytUTBpQ5YiKx03dlgoPmnonb9wFEhDUmH9kcPsuxvxLpWCoFAXqp/nDlK0lDtcgkVOUikT5q4+uoiYJQhlZGd+um1Gd3CmX1jmityCXtSK8loplQKBgQCT2sqA2vw9z9vhfJmdxfPG6lI77HTHtEhhhL7bZ8HaUX1fp4olQ4jT4NdnkgSM0lMHuTdH4PV6E4SM2QDtVKalgPkmrq4K5Axsn5tB2R8hNvG+dZeuk0pjI/xLXWHb3mTmNQXBqvFokHtV/R5Gcb3qhbL2ZjafB+22rKGZgKGJeg==',
            'nobu_merchant_id' => '936005030000078300',
            'nobu_sub_merchant_id' => '26020900000005',
            'nobu_store_id' => 'ID2026020900005',
            // ======================================

            'bank_id' => $bankId,
            'pemilik_rekening' => 'Muhammad Saeful Ramdan',
            'nomor_rekening' => '1234567890',
            'ktp' => 'ktp-sample.png',
            'catatan' => 'Merchant Billinghub Client untuk handle QRIN.',
            'status' => 'approved',
            'beban_biaya' => 'Merchant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('assign_merchants')->insert([
            [
                'user_id' => 1,
                'merchant_id' => $merchantId1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'merchant_id' => $merchantId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Seeder Merchant berhasil: 2 merchant dibuat dan di-assign ke user 1.');
    }
}
