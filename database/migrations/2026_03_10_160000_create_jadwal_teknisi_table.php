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
        Schema::create('jadwal_teknisi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();

            // Relasi ke SPK / PO (akan dihubungkan ke tabel SPK/PO ketika fitur tersebut dibuat)
            $table->uuid('spk_id')->nullable()->comment('Relasi ke SPK/PO');

            // Judul / nama jadwal (opsional)
            $table->string('judul')->nullable();

            // Periode jadwal
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();

            // Keterangan umum jadwal
            $table->text('keterangan')->nullable();

            // User pembuat (Manager Teknik)
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_teknisi');
    }
};

