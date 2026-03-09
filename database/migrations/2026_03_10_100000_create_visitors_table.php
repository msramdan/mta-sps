<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Visitor Sales / Kunjungan Sales - by company (session).
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('Sales Marketing yang kunjungan');
            $table->string('nama_rs');
            $table->string('pic_rs')->comment('Nama PIC / Contact Person RS');
            $table->string('posisi_pic')->nullable()->comment('Jabatan PIC');
            $table->string('no_telp_pic');
            $table->date('tanggal_visit');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
