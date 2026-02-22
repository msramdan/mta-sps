<?php

namespace App\Http\Requests\TarikSaldos;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmTarikSaldoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bukti_trf' => 'required|image|max:2048',
            'catatan' => 'required|string|max:1000',
        ];
    }
}
