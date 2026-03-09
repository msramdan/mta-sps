<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimasiBiayaJadwalTeknisi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'estimasi_biaya_jadwal_teknisi';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'jadwal_teknisi_id',
        'keterangan_biaya',
        'estimasi_total',
        'created_at',
    ];

    protected $casts = [
        'estimasi_total' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function jadwalTeknisi(): BelongsTo
    {
        return $this->belongsTo(JadwalTeknisi::class);
    }
}

