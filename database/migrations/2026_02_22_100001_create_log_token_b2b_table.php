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
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_token_b2b');
    }
};
