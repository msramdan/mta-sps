<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Support\Str;

class TarikSaldo extends Model
{
    use HasFactory;

    protected $table = 'tarik_saldos';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'merchant_id',
        'bank_id',
        'jumlah',
        'biaya',
        'diterima',
        'pemilik_rekening',
        'nomor_rekening',
        'status',
        'bukti_trf',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'id'          => 'string',
            'merchant_id' => 'string',
            'bank_id'     => 'string',
            'jumlah'      => 'float',
            'biaya'       => 'float',
            'diterima'    => 'float',
            'status'      => 'string',
            'created_at'  => 'datetime:Y-m-d H:i:s',
            'updated_at'  => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * Auto-generate UUID
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            Merchant::class,
            'merchant_id',
            'id'
        );
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(
            Bank::class,
            'bank_id',
            'id'
        );
    }

    /**
     * Accessor bukti transfer
     */
    protected function buktiTrf(): Attribute
    {
        $path = 'bukti-trves';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName('public');

        return Attribute::make(
            get: fn (?string $value): string =>
                $imageService->getImageCastUrl(
                    image: $value,
                    path: $path,
                    disk: $disk
                )
        );
    }
}
