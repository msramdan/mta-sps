<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Evidence foto kunjungan (opsional) - format jpg, png, jpeg.
     */
    public function up(): void
    {
        Schema::table('kunjungan_sales', function (Blueprint $table) {
            $table->string('evidence')->nullable()->after('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungan_sales', function (Blueprint $table) {
            $table->dropColumn('evidence');
        });
    }
};
