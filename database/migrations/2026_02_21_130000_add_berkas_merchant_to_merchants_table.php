<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('ktp_lembar_verifikasi')->nullable()->after('ktp');
            $table->string('ktp_photo_selfie')->nullable()->after('ktp_lembar_verifikasi');
            $table->string('photo_toko_tampak_depan')->nullable()->after('ktp_photo_selfie');
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn(['ktp_lembar_verifikasi', 'ktp_photo_selfie', 'photo_toko_tampak_depan']);
        });
    }
};
