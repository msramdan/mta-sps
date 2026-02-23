<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Generators\Services\ImageServiceV2;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'no_wa',
        'log_otp',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime:Y-m-d H:i',
            'created_at' => 'datetime:Y-m-d H:i',
            'updated_at' => 'datetime:Y-m-d H:i',
        ];
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value): string => $this->getAvatarUrl(value: $value)
        );
    }

    private function getAvatarUrl(?string $value): string
    {
        $path = 'avatars';
        $imageService = new ImageServiceV2;
        $disk = $imageService->setDiskName(disk: 'storage.public');

        if (! $value) {
            return $imageService->getPlaceholderImage();
        }

        return match (true) {
            $imageService->isPrivateS3(disk: $disk) || $disk === 'local' => $imageService->getTemporaryUrl(disk: $disk, image: "$path/$value"),
            in_array(needle: $disk, haystack: ['s3', 'public']) => $imageService->getStoragePublicUrl(disk: $disk, image: "$path/$value"),
            default => $imageService->getPublicAssetUrl(image: "$path/$value"),
        };
    }

    public function assignedMerchants()
    {
        return $this->belongsToMany(Merchant::class, 'assign_merchants', 'user_id', 'merchant_id')
            ->withTimestamps();
    }
}
