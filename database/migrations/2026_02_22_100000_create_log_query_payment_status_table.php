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

            $table->text('url_query_payment')->nullable();
            $table->text('payload_merchant_to_qrin')->nullable();
            $table->text('header_qrin_to_nobu')->nullable();
            $table->text('payload_qrin_to_nobu')->nullable();
            $table->text('response_from_nobu_to_qrin')->nullable();
            $table->text('response_from_qrin_to_merchant')->nullable();

            $table->boolean('is_success')->nullable()->comment('Untuk filter cepat saat debug: true = sukses, false = gagal');
            $table->string('processing_time', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_query_payment_status');
    }
};
