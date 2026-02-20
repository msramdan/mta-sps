<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('tanggal_transaksi');
            $table->uuid('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants')->cascadeOnDelete();
            $table->string('no_referensi', 100)->unique();
            $table->string('no_ref_merchant', 100);
            $table->string('nama_pelanggan', 150)->nullable();
            $table->string('email_pelanggan')->nullable();
            $table->string('no_telpon_pelanggan', 20)->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->decimal('jumlah_dibayar', 15, 2)->default(0);
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
