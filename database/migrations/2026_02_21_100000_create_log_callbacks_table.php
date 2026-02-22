<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_callbacks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->cascadeOnDelete();
            $table->uuid('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            $table->text('header_callback_nobu_to_qrin')->nullable();
            $table->text('payload_callback_nobu_to_qrin')->nullable();
            $table->text('response_callback_nobu_to_qrin')->nullable();
            $table->dateTime('tanggal_callback_nobu_to_qrin')->nullable();
            $table->text('header_callback_qrin_to_merchant')->nullable();
            $table->text('payload_callback_qrin_to_merchant')->nullable();
            $table->text('response_callback_qrin_to_merchant')->nullable();
            $table->dateTime('tanggal_callback_qrin_to_merchant')->nullable();
            $table->string('processing_time', 50)->nullable();
            $table->string('transaction_status', 50)->nullable();
            $table->text('status_desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_callbacks');
    }
};
