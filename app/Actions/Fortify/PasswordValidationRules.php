<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     */
    protected function passwordRules(): array
    {
        // Minimal 8 karakter berlaku di semua environment
        $validations = ['confirmed'];

        if (app()->isProduction()) {
            $validations[] = Password::min(size: 8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        } else {
            $validations[] = Password::min(size: 8);
        }

        return $validations;
    }
}
