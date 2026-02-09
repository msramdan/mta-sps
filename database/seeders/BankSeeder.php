<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            // BUMN
            'Bank Mandiri',
            'Bank Rakyat Indonesia (BRI)',
            'Bank Negara Indonesia (BNI)',
            'Bank Tabungan Negara (BTN)',

            // Swasta besar
            'Bank Central Asia (BCA)',
            'Bank CIMB Niaga',
            'Bank Danamon',
            'Bank Permata',
            'Bank Panin',
            'Bank OCBC NISP',
            'Bank Mega',
            'Bank Maybank Indonesia',

            // Syariah terkenal
            'Bank Syariah Indonesia (BSI)',
            'Bank Muamalat Indonesia',
            'Bank BCA Syariah',

            // Digital populer
            'Bank Jago',
            'Bank Neo Commerce (BNC)',
            'SeaBank Indonesia',
            'blu by BCA Digital',
        ];

        DB::table('banks')->insert(
            array_map(fn ($bank) => [
                'id' => (string) Str::uuid(),
                'nama_bank' => $bank,
                'created_at' => now(),
                'updated_at' => now(),
            ], $banks)
        );
    }
}
