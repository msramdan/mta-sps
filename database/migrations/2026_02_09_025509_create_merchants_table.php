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
            $table->string('logo');
            $table->string('url_callback');
            $table->string('apikey');
            $table->string('secretkey');

            // FK ke banks (UUID)
            $table->uuid('bank_id');
            $table
                ->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->cascadeOnDelete();

            $table->string('pemilik_rekening', 100);
            $table->string('nomor_rekening', 50);
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
