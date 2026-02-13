<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarik_saldos', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('merchant_id');
            $table->uuid('bank_id');

            $table->float('jumlah');
            $table->float('biaya');
            $table->float('diterima');

            $table->string('pemilik_rekening');
            $table->string('nomor_rekening');

            $table->enum('status', ['pending','process','success','reject','cancel'])
                  ->default('pending');

            $table->string('bukti_trf')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('merchant_id')
                  ->references('id')
                  ->on('merchants')
                  ->cascadeOnDelete();

            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarik_saldos');
    }
};
