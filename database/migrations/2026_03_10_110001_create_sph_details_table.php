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
        Schema::create('sph_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sph_id')->constrained('sph')->cascadeOnDelete();
            $table->unsignedInteger('version')->comment('1, 2, 3, ...');
            $table->string('file_path')->nullable()->comment('Path attachment - bisa sama dengan versi sebelumnya jika tidak upload baru');
            $table->text('catatan_revisi')->nullable();
            $table->unsignedInteger('total_download')->default(0)->comment('Jumlah download');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sph_details');
    }
};
