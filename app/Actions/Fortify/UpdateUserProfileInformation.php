<?php

namespace App\Actions\Fortify;

use App\Generators\Services\ImageServiceV2;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public string $avatarPath;
    public string $disk;

    public function __construct(string $avatarPath = 'avatars', string $disk = 's3')
    {
        $this->avatarPath = $avatarPath;
        $this->disk = $disk;
    }

    /**
     * Validate and update the given user's profile information.
     */
    public function update(User $user, array $input): void
    {
        Validator::make(data: $input, rules: [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(table: 'users')->ignore(id: $user->id),
            ],
            'no_wa' => [
                'required',
                'string',
                'regex:/^(08|62)[0-9]{8,11}$/',
                Rule::unique(table: 'users', column: 'no_wa')->ignore(id: $user->id),
            ],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'log_otp' => ['nullable', 'in:Yes,No'],
        ])->validateWithBag(errorBag: 'updateProfileInformation');

        if (isset($input['avatar']) && $input['avatar']->isValid()) {
            $filename = (new ImageServiceV2)->upload(
                name: 'avatar',
                path: $this->avatarPath,
                defaultImage: $user->getRawOriginal('avatar'),
                disk: $this->disk
            );

            $user->forceFill(attributes: ['avatar' => $filename])->save();
        }

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser(user: $user, input: $input);
        } else {
            $user->forceFill(attributes: [
                'name' => $input['name'],
                'email' => $input['email'],
                'no_wa' => $input['no_wa'],
                'log_otp' => ($input['log_otp'] ?? 'No') === 'Yes' ? 'Yes' : 'No',
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'no_wa' => $input['no_wa'],
            'log_otp' => ($input['log_otp'] ?? 'No') === 'Yes' ? 'Yes' : 'No',
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
