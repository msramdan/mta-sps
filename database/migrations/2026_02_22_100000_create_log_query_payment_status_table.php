<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_query_payment_status', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->nullOnDelete();
            $table->uuid('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            $table->text('payload_merchant_to_qrin')->nullable();
            $table->text('payload_qrin_to_nobu')->nullable();
            $table->text('response_generate_qr')->nullable();
            $table->boolean('is_success')->nullable()->comment('Untuk filter cepat saat debug: true = sukses, false = gagal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_query_payment_status');
    }
};
