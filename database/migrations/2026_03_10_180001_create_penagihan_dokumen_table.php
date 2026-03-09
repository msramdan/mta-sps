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
        Schema::create('penagihan_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penagihan_id')->constrained('penagihan')->cascadeOnDelete();
            $table->string('jenis_dokumen', 50)->comment('daily_report, sertifikat, subkon, invoice, faktur');
            $table->boolean('is_checked')->default(false);
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable()->comment('Nama file asli');
            $table->timestamp('uploaded_at')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['penagihan_id', 'jenis_dokumen']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penagihan_dokumen');
    }
};
