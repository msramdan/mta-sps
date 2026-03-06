<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah default balance menjadi 0 jika null
        DB::statement('UPDATE merchants SET balance = 0 WHERE balance IS NULL');

        // MySQL 8.0+ mendukung CHECK constraint
        // Tambah CHECK constraint untuk mencegah balance negatif
        try {
            DB::statement('ALTER TABLE merchants ADD CONSTRAINT chk_balance_non_negative CHECK (balance >= 0)');
        } catch (\Exception $e) {
            // Jika gagal (MySQL versi lama), log warning tapi jangan gagal migrasi
            // Proteksi tetap ada di level aplikasi
            \Illuminate\Support\Facades\Log::warning('Could not add CHECK constraint for balance: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE merchants DROP CONSTRAINT chk_balance_non_negative');
        } catch (\Exception $e) {
            // Constraint mungkin tidak ada
        }
    }
};
