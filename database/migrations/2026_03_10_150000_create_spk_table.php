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
        Schema::create('spk', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('sph_id')->constrained('sph')->cascadeOnDelete();
            $table->string('no_spk', 50)->comment('No. SPK/PO - format SPK-YYYYMMDD-XXX');
            $table->decimal('nilai_kontrak', 18, 2)->default(0);
            $table->boolean('include_ppn')->default(false)->comment('Ceklis Include PPN');
            $table->unsignedInteger('jumlah_alat')->default(0);
            $table->date('tanggal_spk');
            $table->date('tanggal_deadline')->nullable();
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
        Schema::dropIfExists('spk');
    }
};
