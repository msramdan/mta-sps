<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogCallback extends Model
{
    use HasFactory;

    protected $table = 'log_callbacks';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'transaksi_id',
        'merchant_id',
        'payload_callback',
        'tanggal_callback',
        'transaction_status',
        'status_desc',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'transaksi_id' => 'string',
            'merchant_id' => 'string',
            'tanggal_callback' => 'datetime',
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
