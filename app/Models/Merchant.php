<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Generators\Services\ImageServiceV2;

class Merchant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'merchants';

    /**
     * Primary key type & increment.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama_merchant',
        'logo',
        'url_callback',
        'apikey',
        'secretkey',
        'bank_id',
        'pemilik_rekening',
        'nomor_rekening',
        'ktp', // Tambahan
        'catatan', // Tambahan
        'status',
    ];

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'nama_merchant' => 'string',
            'logo' => 'string',
            'url_callback' => 'string',
            'apikey' => 'string',
            'secretkey' => 'string',
            'bank_id' => 'string', // UUID FK
            'pemilik_rekening' => 'string',
            'nomor_rekening' => 'string',
            'ktp' => 'string', // Tambahan
            'catatan' => 'string', // Tambahan
            'status' => 'string',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * Auto-generate UUID for primary key.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation: Merchant belongs to Bank (UUID).
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Bank::class, 'bank_id');
    }

    /**
     * Accessor for the 'logo' attribute.
     */
    protected function logo(): Attribute
    {
        $path = 'logos';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');

        return Attribute::make(
            get: fn (?string $value): string =>
                $imageService->getImageCastUrl(
                    image: $value,
                    path: $path,
                    disk: $disk
                )
        );
    }

    protected function ktp(): Attribute
    {
        $path = 'ktps';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');

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
