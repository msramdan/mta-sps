<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogResendCallback extends Model
{
    use HasFactory;

    protected $table = 'log_resend_callbacks';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'transaksi_id',
        'merchant_id',
        'metode',
        'url_callback',
        'header_resend_callback_qrin_to_merchant',
        'payload_resend_callback_qrin_to_merchant',
        'response_resend_callback_qrin_to_merchant',
        'tanggal_resend_callback_qrin_to_merchant',
        'processing_time',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'transaksi_id' => 'string',
            'merchant_id' => 'string',
            'tanggal_resend_callback_qrin_to_merchant' => 'datetime',
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
