<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_token_b2b', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('header')->nullable();
            $table->text('payload')->nullable();
            $table->text('response')->nullable();
            $table->string('processing_time', 50)->nullable();
            $table->boolean('is_success')->nullable()->comment('Untuk filter cepat saat debug: true = sukses, false = gagal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_token_b2b');
    }
};
