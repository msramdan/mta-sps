<?php

namespace App\Http\Requests\Spk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $spkId = $this->route('spk')?->id;

        return [
            'sph_id' => ['required', 'exists:sph,id'],
            'no_spk' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('spk', 'no_spk')
                    ->where('company_id', session('session_company_id'))
                    ->ignore($spkId),
            ],
            'nilai_kontrak' => ['required', 'numeric', 'min:0'],
            'include_ppn' => ['nullable', 'boolean'],
            'jumlah_alat' => ['required', 'integer', 'min:0'],
            'tanggal_spk' => ['required', 'date'],
            'tanggal_deadline' => ['nullable', 'date', 'after_or_equal:tanggal_spk'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['include_ppn' => $this->boolean('include_ppn')]);
    }
}
