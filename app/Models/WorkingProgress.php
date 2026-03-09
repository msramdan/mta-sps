<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkingProgress extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'working_progress';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'jadwal_teknisi_id',
        'tanggal',
        'jumlah_selesai',
        'keterangan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function jadwalTeknisi(): BelongsTo
    {
        return $this->belongsTo(JadwalTeknisi::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
