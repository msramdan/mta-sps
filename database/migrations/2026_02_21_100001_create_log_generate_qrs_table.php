<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_generate_qrs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->nullOnDelete();
            $table->uuid('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            $table->text('payload_merchant_to_qrin')->nullable();
            // token b2b
            $table->text('url_token_b2b')->nullable();
            $table->text('header_b2b_qrin_to_nobu')->nullable();
            $table->text('payload_b2b_qrin_to_nobu')->nullable();
            $table->text('response_b2b_from_nobu_to_qrin')->nullable();
            // show qr code
            $table->text('url_show_qr_b2b')->nullable();
            $table->text('header_show_qr_qrin_to_nobu')->nullable();
            $table->text('payload_show_qr_qrin_to_nobu')->nullable();
            $table->text('response_show_qr_from_nobu_to_qrin')->nullable();

            $table->text('response_qrin_to_merchant')->nullable();

            $table->boolean('is_success')->nullable()->comment('Untuk filter cepat saat debug: true = sukses, false = gagal');
            $table->string('processing_time', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_generate_qrs');
    }
};
