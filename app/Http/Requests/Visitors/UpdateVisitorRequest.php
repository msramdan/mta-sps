<?php

namespace App\Http\Requests\Visitors;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitorRequest extends FormRequest
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
        ];
    }
}
