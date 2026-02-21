<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('beban_biaya', 20)->default('Merchant')->after('status')
                ->comment('Merchant = biaya ditanggung merchant, Pelanggan = biaya ditanggung pelanggan');
            $table->decimal('jumlah_diterima', 15, 2)->default(0)->after('jumlah_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['beban_biaya', 'jumlah_diterima']);
        });
    }
};
