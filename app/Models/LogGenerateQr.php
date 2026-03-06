<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogGenerateQr extends Model
{
    use HasFactory;

    protected $table = 'log_generate_qrs';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'transaksi_id',
        'merchant_id',
        'payload_merchant_to_qrin',
        'url_token_b2b',
        'header_b2b_qrin_to_nobu',
        'payload_b2b_qrin_to_nobu',
        'response_b2b_from_nobu_to_qrin',
        'url_show_qr_b2b',
        'header_show_qr_qrin_to_nobu',
        'payload_show_qr_qrin_to_nobu',
        'response_show_qr_from_nobu_to_qrin',
        'response_qrin_to_merchant',
        'is_success',
        'processing_time',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'transaksi_id' => 'string',
            'merchant_id' => 'string',
            'is_success' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
