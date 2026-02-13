<?php

namespace App\Http\Requests\TarikSaldos;

use Illuminate\Foundation\Http\FormRequest;

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
			'jumlah' => 'required|numeric|min:200000',
        ];
    }
}
