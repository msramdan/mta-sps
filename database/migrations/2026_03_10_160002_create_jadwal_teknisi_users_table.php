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
        Schema::create('jadwal_teknisi_users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('jadwal_teknisi_id')
                ->constrained('jadwal_teknisi')
                ->cascadeOnDelete();

            // User teknisi (role id = 2 / role "Teknisi")
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_teknisi_users');
    }
};

