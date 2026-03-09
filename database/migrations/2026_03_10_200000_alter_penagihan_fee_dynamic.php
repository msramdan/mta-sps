<?php

use App\Models\PenagihanFee;
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
        // Migrate existing: copy jenis_fee label to keterangan
        if (Schema::hasColumn('penagihan_fee', 'jenis_fee')) {
            foreach (PenagihanFee::all() as $f) {
                if (empty($f->getRawOriginal('keterangan'))) {
                    $label = config("penagihan.jenis_fee.{$f->jenis_fee}", $f->jenis_fee);
                    $f->updateQuietly(['keterangan' => $label]);
                }
            }
        }

        Schema::table('penagihan_fee', function (Blueprint $table) {
            $table->index('penagihan_id');
        });
        Schema::table('penagihan_fee', function (Blueprint $table) {
            $table->dropUnique(['penagihan_id', 'jenis_fee']);
        });
        Schema::table('penagihan_fee', function (Blueprint $table) {
            $table->dropColumn(['jenis_fee', 'is_dicairkan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penagihan_fee', function (Blueprint $table) {
            $table->string('jenis_fee', 50)->nullable()->after('penagihan_id');
            $table->boolean('is_dicairkan')->default(false)->after('keterangan');
        });
    }
};
