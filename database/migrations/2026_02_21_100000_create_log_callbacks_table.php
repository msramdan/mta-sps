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
            $table->uuid('transaksi_id');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->cascadeOnDelete();
            $table->uuid('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->nullOnDelete();
            $table->text('payload_callback')->nullable();
            $table->dateTime('tanggal_callback')->nullable();
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
