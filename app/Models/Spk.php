<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spk extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'spk';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'sph_id',
        'no_spk',
        'nilai_kontrak',
        'include_ppn',
        'jumlah_alat',
        'tanggal_spk',
        'tanggal_deadline',
        'keterangan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'nilai_kontrak' => 'decimal:2',
            'include_ppn' => 'boolean',
            'tanggal_spk' => 'date',
            'tanggal_deadline' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function sph(): BelongsTo
    {
        return $this->belongsTo(Sph::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jadwalTeknisi(): HasMany
    {
        return $this->hasMany(JadwalTeknisi::class);
    }

    public function getNilaiKontrakFormattedAttribute(): string
    {
        return number_format($this->nilai_kontrak, 2, ',', '.');
    }
}
