<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalTeknisi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jadwal_teknisi';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'spk_id',
        'judul',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teknisi(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'jadwal_teknisi_users')
            ->withTimestamps();
    }

    public function estimasiBiaya(): HasMany
    {
        return $this->hasMany(EstimasiBiayaJadwalTeknisi::class);
    }

    public function getTotalEstimasiAttribute(): float
    {
        return (float) $this->estimasiBiaya()->sum('estimasi_total');
    }
}

