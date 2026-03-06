<?php

namespace App\Http\Requests\TarikSaldos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreTarikSaldoRequest extends FormRequest
{
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
            'jumlah' => 'required|numeric|min:20000|max:50000000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'jumlah.min' => 'Minimal penarikan adalah Rp 20.000.',
            'jumlah.max' => 'Maksimal penarikan adalah Rp 50.000.000 per pengajuan.',
        ];
    }
}
