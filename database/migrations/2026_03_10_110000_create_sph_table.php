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
        Schema::create('sph', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->string('no_sph')->comment('Nomor SPH - format SPH-YYYYMMDD-XXX');
            $table->foreignUuid('kunjungan_sale_id')->nullable()->constrained('kunjungan_sales')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('Sales Marketing - info dari sales');
            $table->date('tanggal_sph');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('Admin yang input');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sph');
    }
};
