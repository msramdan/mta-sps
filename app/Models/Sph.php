<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sph extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sph';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'no_sph',
        'kunjungan_sale_id',
        'user_id',
        'tanggal_sph',
        'keterangan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sph' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kunjunganSale(): BelongsTo
    {
        return $this->belongsTo(KunjunganSale::class, 'kunjungan_sale_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SphDetail::class)->orderBy('version');
    }

    public function spks(): HasMany
    {
        return $this->hasMany(Spk::class);
    }

    /** Versi terakhir (tertinggi) */
    public function latestDetail(): ?SphDetail
    {
        return $this->details()->orderByDesc('version')->first();
    }
}
