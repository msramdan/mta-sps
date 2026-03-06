<?php

namespace App\Http\Requests\Merchants;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantRequest extends FormRequest
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
            'nama_merchant' => 'required|string|max:150',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'url_callback' => 'required|url',
            'token_qrin' => 'required|string',
            'bank_id' => 'required|exists:App\Models\Bank,id',
            'pemilik_rekening' => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'status' => 'required|in:pending,approved,rejected,suspended',
            'beban_biaya' => 'required|in:Merchant,Pelanggan',
            'ktp' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'ktp_lembar_verifikasi' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'ktp_photo_selfie' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'photo_toko_tampak_depan' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'nobu_client_id' => 'nullable|string|max:255',
            'nobu_partner_id' => 'nullable|string|max:255',
            'nobu_client_secret' => 'nullable|string|max:255',
            'nobu_merchant_id' => 'nullable|string|max:255',
            'nobu_sub_merchant_id' => 'nullable|string|max:255',
            'nobu_store_id' => 'nullable|string|max:255',
            'nobu_private_key' => 'nullable|string',
        ];
    }
}
