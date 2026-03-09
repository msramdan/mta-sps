<?php

namespace App\Http\Requests\Sph;

use Illuminate\Foundation\Http\FormRequest;

class StoreSphRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_sph' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('sph', 'no_sph')->where('company_id', session('session_company_id')),
            ],
            'kunjungan_sale_id' => ['nullable', 'exists:kunjungan_sales,id'],
            'tanggal_sph' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'catatan_revisi' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'no_sph.required' => 'Nomor SPH wajib diisi.',
            'no_sph.unique' => 'Nomor SPH sudah digunakan. Silakan refresh halaman.',
            'tanggal_sph.required' => 'Tanggal SPH wajib diisi.',
        ];
    }
}
