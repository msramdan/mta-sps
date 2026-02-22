<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tarik_saldos', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('bukti_trf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarik_saldos', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
