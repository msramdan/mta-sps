<?php

namespace App\Http\Requests\Users;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'no_wa' => ['required', 'string', 'regex:/^(08|62)[0-9]{8,11}$/', 'unique:users,no_wa'],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['required', ...$this->passwordRules()],
            'companies' => ['required', 'array', 'min:1'],
            'companies.*' => ['exists:companies,id'],
            'log_otp' => ['nullable', 'in:Yes,No'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'companies.required' => 'Pilih minimal 1 perusahaan.',
            'companies.min' => 'Pilih minimal 1 perusahaan.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp harus diawali 08 atau 62, minimal 8 digit, maksimal 13 digit.',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar.',
        ];
    }
}
