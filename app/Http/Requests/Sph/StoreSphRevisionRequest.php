<?php

namespace App\Http\Requests\Sph;

use Illuminate\Foundation\Http\FormRequest;

class StoreSphRevisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->kunjungan_sale_id === '') {
            $this->merge(['kunjungan_sale_id' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'tanggal_sph' => ['required', 'date'],
            'kunjungan_sale_id' => ['nullable', 'exists:kunjungan_sales,id'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'catatan_revisi' => ['nullable', 'string', 'max:500'],
        ];
    }
}
