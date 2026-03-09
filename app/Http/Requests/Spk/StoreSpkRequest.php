<?php

namespace App\Http\Requests\Spk;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sph_id' => ['required', 'exists:sph,id'],
            'no_spk' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('spk', 'no_spk')->where('company_id', session('session_company_id')),
            ],
            'nilai_kontrak' => ['required', 'numeric', 'min:0'],
            'include_ppn' => ['nullable', 'boolean'],
            'jumlah_alat' => ['required', 'integer', 'min:0'],
            'tanggal_spk' => ['required', 'date'],
            'tanggal_deadline' => ['nullable', 'date', 'after_or_equal:tanggal_spk'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'sph_id.required' => 'SPH wajib dipilih.',
            'sph_id.exists' => 'SPH tidak valid.',
            'no_spk.required' => 'No. SPK/PO wajib diisi.',
            'no_spk.unique' => 'No. SPK/PO sudah digunakan. Silakan refresh halaman.',
            'nilai_kontrak.required' => 'Nilai kontrak wajib diisi.',
            'jumlah_alat.required' => 'Jumlah alat wajib diisi.',
            'tanggal_spk.required' => 'Tanggal SPK wajib diisi.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['include_ppn' => $this->boolean('include_ppn')]);
    }
}
