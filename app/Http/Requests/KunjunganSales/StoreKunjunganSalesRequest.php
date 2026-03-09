<?php

namespace App\Http\Requests\KunjunganSales;

use Illuminate\Foundation\Http\FormRequest;

class StoreKunjunganSalesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_rs' => ['required', 'string', 'max:255'],
            'pic_rs' => ['required', 'string', 'max:255'],
            'posisi_pic' => ['nullable', 'string', 'max:255'],
            'no_telp_pic' => ['required', 'string', 'max:50'],
            'tanggal_visit' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
            'evidence' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_rs.required' => 'Nama RS wajib diisi.',
            'pic_rs.required' => 'Nama PIC RS wajib diisi.',
            'no_telp_pic.required' => 'No. Telepon PIC wajib diisi.',
            'tanggal_visit.required' => 'Tanggal kunjungan wajib diisi.',
        ];
    }
}
