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
            'merchant_id' => 'required|exists:App\Models\Merchant,id',
			'jumlah' => 'required|numeric',
			'biaya' => 'required|numeric',
			'diterima' => 'required|numeric',
			'bank_id' => 'required|exists:App\Models\Bank,id',
			'pemilik_rekening' => 'required|string',
			'nomor_rekening' => 'required|string',
			'status' => 'required|in:pending,process,success,reject',
			'bukti_trf' => 'required|image|max:2048',
        ];
    }
}
