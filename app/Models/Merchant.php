<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Generators\Services\ImageServiceV2;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Merchant extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->logExcept(['token_qrin', 'nobu_client_secret', 'nobu_private_key'])
            ->setDescriptionForEvent(fn (string $eventName) => "Merchant {$eventName}");
    }

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
        'kode_merchant',
        'nama_merchant',
        'balance',
        'logo',
        'url_callback',
        'token_qrin',
        // NOBU FIELDS
        'nobu_client_id',
        'nobu_partner_id',
        'nobu_client_secret',
        'nobu_private_key',
        'nobu_merchant_id',
        'nobu_sub_merchant_id',
        'nobu_store_id',
        // END NOBU FIELDS
        'bank_id',
        'pemilik_rekening',
        'nomor_rekening',
        'ktp',
        'ktp_lembar_verifikasi',
        'ktp_photo_selfie',
        'photo_toko_tampak_depan',
        'catatan',
        'status',
        'beban_biaya',
    ];

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'kode_merchant' => 'string',
            'nama_merchant' => 'string',
            'balance' => 'decimal:2',
            'logo' => 'string',
            'url_callback' => 'string',
            'token_qrin' => 'string',
            // NOBU CASTS
            'nobu_client_id' => 'string',
            'nobu_partner_id' => 'string',
            'nobu_client_secret' => 'string',
            'nobu_private_key' => 'string',
            'nobu_merchant_id' => 'string',
            'nobu_sub_merchant_id' => 'string',
            'nobu_store_id' => 'string',
            // END NOBU CASTS
            'bank_id' => 'string',
            'pemilik_rekening' => 'string',
            'nomor_rekening' => 'string',
            'ktp' => 'string',
            'ktp_lembar_verifikasi' => 'string',
            'ktp_photo_selfie' => 'string',
            'photo_toko_tampak_depan' => 'string',
            'catatan' => 'string',
            'status' => 'string',
            'beban_biaya' => 'string',
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

            // Auto-generate kode_merchant if not set
            if (empty($model->kode_merchant)) {
                do {
                    $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $kodeMerchant = 'QR' . $randomNumber;
                } while (self::where('kode_merchant', $kodeMerchant)->exists());

                $model->kode_merchant = $kodeMerchant;
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

    /**
     * Accessor for the 'ktp' attribute.
     */
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

    protected function ktpLembarVerifikasi(): Attribute
    {
        $path = 'ktp-lembar-verifikasi';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');
        return Attribute::make(
            get: fn (?string $value): string =>
                $imageService->getImageCastUrl(image: $value, path: $path, disk: $disk)
        );
    }

    protected function ktpPhotoSelfie(): Attribute
    {
        $path = 'ktp-photo-selfie';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');
        return Attribute::make(
            get: fn (?string $value): string =>
                $imageService->getImageCastUrl(image: $value, path: $path, disk: $disk)
        );
    }

    protected function photoTokoTampakDepan(): Attribute
    {
        $path = 'photo-toko-tampak-depan';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');
        return Attribute::make(
            get: fn (?string $value): string =>
                $imageService->getImageCastUrl(image: $value, path: $path, disk: $disk)
        );
    }
}
