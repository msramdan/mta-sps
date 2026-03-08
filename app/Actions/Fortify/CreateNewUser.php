<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     */
    public function create(array $input): User
    {
        Validator::make(data: $input, rules: [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(table: User::class),
            ],
            'no_wa' => ['nullable', 'string', 'max:13'],
            'password' => ['required', ...$this->passwordRules()],
        ])->validate();

        return User::create(attributes: [
            'name' => $input['name'],
            'email' => $input['email'],
            'no_wa' => $input['no_wa'] ?? null,
            'password' => Hash::make(value: $input['password']),
        ]);
    }
}
