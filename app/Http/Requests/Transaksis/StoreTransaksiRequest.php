<?php

namespace App\Http\Requests\Transaksis;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $merchantId = session('sessionMerchant');

        if (!$merchantId) {
            abort(403, 'Merchant session tidak ditemukan. Silakan pilih merchant terlebih dahulu.');
        }

        $this->merge([
            'merchant_id' => $merchantId,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'merchant_id' => 'required|exists:merchants,id',
            'tanggal_transaksi' => 'nullable|date',
            'no_ref_merchant' => 'required|string|max:100',
            'nama_pelanggan' => 'nullable|string|max:150',
            'email_pelanggan' => 'nullable|email|max:255',
            'no_telpon_pelanggan' => 'nullable|string|max:20',
            'biaya' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'status' => 'required|in:pending,success,failed,expired',
            'payload_generate_qr' => 'nullable|string',
            'callback' => 'nullable|string',
            'tanggal_callback' => 'nullable|date',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'tanggal_transaksi' => 'Tanggal Transaksi',
            'no_ref_merchant' => 'No. Referensi Merchant',
            'nama_pelanggan' => 'Nama Pelanggan',
            'email_pelanggan' => 'Email Pelanggan',
            'no_telpon_pelanggan' => 'No. Telepon Pelanggan',
            'biaya' => 'Biaya',
            'jumlah_dibayar' => 'Jumlah Dibayar',
            'status' => 'Status',
            'payload_generate_qr' => 'Payload Generate QR',
            'callback' => 'Callback',
            'tanggal_callback' => 'Tanggal Callback',
        ];
    }
}
