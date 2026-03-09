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
        Schema::create('estimasi_biaya_jadwal_teknisi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('jadwal_teknisi_id')
                ->constrained('jadwal_teknisi')
                ->cascadeOnDelete();

            // Contoh: "Tiket Pesawat PP", "Hotel", "Uang Saku", dll
            $table->string('keterangan_biaya');

            // Nilai estimasi total (tanpa qty, langsung total)
            $table->decimal('estimasi_total', 15, 2)->default(0);

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimasi_biaya_jadwal_teknisi');
    }
};

