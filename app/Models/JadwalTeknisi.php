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

    public function spk(): BelongsTo
    {
        return $this->belongsTo(Spk::class);
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

    public function workingProgress(): HasMany
    {
        return $this->hasMany(WorkingProgress::class)->orderBy('tanggal');
    }

    /** Total alat dari SPK (0 jika tidak ada SPK) */
    public function getTotalAlatAttribute(): int
    {
        return (int) ($this->spk?->jumlah_alat ?? 0);
    }

    /** Jumlah alat sudah selesai (dari working progress) */
    public function getJumlahSelesaiAttribute(): int
    {
        return (int) $this->workingProgress()->sum('jumlah_selesai');
    }

    /** Progress persentase (0-100) */
    public function getProgressPercentAttribute(): float
    {
        $total = $this->total_alat;
        if ($total <= 0) {
            return 0.0;
        }

        return min(100, round(($this->jumlah_selesai / $total) * 100, 2));
    }

    public function getTotalEstimasiAttribute(): float
    {
        return (float) $this->estimasiBiaya()->sum('estimasi_total');
    }
}

