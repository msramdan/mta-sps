<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_resend_callbacks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_id')->nullable();
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->cascadeOnDelete();
            $table->uuid('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            $table->text('header_resend_callback_qrin_to_merchant')->nullable();
            $table->text('payload_resend_callback_qrin_to_merchant')->nullable();
            $table->text('response_resend_callback_qrin_to_merchant')->nullable();
            $table->dateTime('tanggal_resend_callback_qrin_to_merchant')->nullable();
            $table->string('processing_time', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_resend_callbacks');
    }
};
