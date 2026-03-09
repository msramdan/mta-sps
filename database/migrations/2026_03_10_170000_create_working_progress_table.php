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
        Schema::create('working_progress', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jadwal_teknisi_id')
                ->constrained('jadwal_teknisi')
                ->cascadeOnDelete();
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_selesai')->default(0)->comment('Jumlah alat selesai dikerjakan di hari ini');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_progress');
    }
};
