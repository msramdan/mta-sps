<?php

namespace App\Http\Requests\TarikSaldos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusTarikSaldoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:process,reject',
        ];
    }
}
