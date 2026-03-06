<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogQueryPaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'log_query_payment_status';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'transaksi_id',
        'merchant_id',
        'url_query_payment',
        'payload_merchant_to_qrin',
        'header_qrin_to_nobu',
        'payload_qrin_to_nobu',
        'response_from_nobu_to_qrin',
        'response_from_qrin_to_merchant',
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
