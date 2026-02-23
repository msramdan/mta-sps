<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_resend_callbacks', function (Blueprint $table) {
            $table->string('metode', 10)->nullable()->after('merchant_id');
            $table->text('url_callback')->nullable()->after('metode');
        });
    }

    public function down(): void
    {
        Schema::table('log_resend_callbacks', function (Blueprint $table) {
            $table->dropColumn(['metode', 'url_callback']);
        });
    }
};
