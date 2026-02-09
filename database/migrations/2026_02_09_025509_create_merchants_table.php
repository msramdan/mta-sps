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
        Schema::create('merchants', function (Blueprint $table) {
            // Primary key UUID
            $table->uuid('id')->primary();

            $table->string('nama_merchant', 150);
            $table->string('logo')->nullable();
            $table->string('url_callback')->nullable();
            $table->string('apikey')->nullable();
            $table->string('secretkey')->nullable();

            // FK ke banks (UUID)
            $table->uuid('bank_id')->nullable();
            $table
                ->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->nullOnDelete();

            $table->string('pemilik_rekening', 100)->nullable();
            $table->string('nomor_rekening', 50)->nullable();
            $table->string('ktp')->nullable();
            $table->text('catatan')->nullable();

            $table->enum('is_active', ['Yes', 'No'])->default('Yes');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
