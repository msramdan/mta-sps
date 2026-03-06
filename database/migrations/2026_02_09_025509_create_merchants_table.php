<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_merchant', 8)->unique();
            $table->string('nama_merchant', 150);
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('logo')->nullable();
            $table->string('url_callback')->nullable();
            $table->string('token_qrin')->nullable();

            // === 7 FIELD UNTUK NOBU ===
            $table->string('nobu_client_id')->nullable();
            $table->string('nobu_partner_id')->nullable();
            $table->string('nobu_client_secret')->nullable();
            $table->text('nobu_private_key')->nullable();
            $table->string('nobu_merchant_id')->nullable();
            $table->string('nobu_sub_merchant_id')->nullable();
            $table->string('nobu_store_id')->nullable();
            // ==========================

            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->nullOnDelete();
            $table->string('pemilik_rekening', 100)->nullable();
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('ktp')->nullable();
            $table->string('ktp_lembar_verifikasi')->nullable();
            $table->string('ktp_photo_selfie')->nullable();
            $table->string('photo_toko_tampak_depan')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'waiting_review', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->string('beban_biaya', 20)->default('Merchant')
                ->comment('Merchant = biaya ditanggung merchant, Pelanggan = biaya ditanggung pelanggan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
