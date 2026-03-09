<?php

namespace App\Models;

use App\Generators\Services\ImageServiceV2;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KunjunganSale extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kunjungan_sales';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'user_id',
        'nama_rs',
        'pic_rs',
        'posisi_pic',
        'no_telp_pic',
        'tanggal_visit',
        'keterangan',
        'evidence',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_visit' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** Sales Marketing yang melakukan kunjungan */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** URL foto evidence (untuk tampilan) */
    protected function evidence(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value): ?string => $this->getEvidenceUrl($value)
        );
    }

    private function getEvidenceUrl(?string $value): ?string
    {
        if (! $value) {
            return null;
        }
        $path = 'kunjungan_sales';
        $imageService = new ImageServiceV2;
        $disk = $imageService->setDiskName(disk: 's3');
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return match (true) {
            $imageService->isPrivateS3(disk: $disk) || $disk === 'local' => $imageService->getTemporaryUrl(disk: $disk, image: "$path/$value"),
            in_array(needle: $disk, haystack: ['s3', 'public']) => $imageService->getStoragePublicUrl(disk: $disk, image: "$path/$value"),
            default => $imageService->getPublicAssetUrl(image: "$path/$value"),
        };
    }
}
