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
        Schema::create('penagihan_fee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penagihan_id')->constrained('penagihan')->cascadeOnDelete();
            $table->string('jenis_fee', 50)->comment('cashback, kickback, uang_saku, dll');
            $table->decimal('nominal', 18, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->boolean('is_dicairkan')->default(false)->comment('Ceklis sudah dicairkan/dibayar');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['penagihan_id', 'jenis_fee']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penagihan_fee');
    }
};
