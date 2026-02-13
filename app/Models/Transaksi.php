<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'transaksis';

    /**
     * Primary key type & increment.
     */
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tanggal_transaksi',
        'merchant_id',
        'no_referensi',
        'no_ref_merchant',
        'nama_pelanggan',
        'email_pelanggan',
        'no_telpon_pelanggan',
        'biaya',
        'jumlah_dibayar',
        'status',
        'payload_generate_qr',
        'callback',
        'tanggal_callback',
    ];

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'tanggal_transaksi' => 'datetime',
            'merchant_id' => 'string',
            'no_referensi' => 'string',
            'no_ref_merchant' => 'string',
            'nama_pelanggan' => 'string',
            'email_pelanggan' => 'string',
            'no_telpon_pelanggan' => 'string',
            'biaya' => 'decimal:2',
            'jumlah_dibayar' => 'decimal:2',
            'status' => 'string',
            'payload_generate_qr' => 'string',
            'callback' => 'string',
            'tanggal_callback' => 'datetime',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * Auto-generate UUID for primary key.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Auto-set tanggal_transaksi if not set
            if (empty($model->tanggal_transaksi)) {
                $model->tanggal_transaksi = now();
            }

            // Auto-generate no_referensi if not set
            // Format: kode_merchant-Ymd-6 digit random
            if (empty($model->no_referensi)) {
                // Get merchant's kode_merchant
                $merchant = Merchant::find($model->merchant_id);
                $kodeMerchant = $merchant ? $merchant->kode_merchant : 'UNKNOWN';

                do {
                    $datePart = now()->format('ymd'); // Ymd format (260213)
                    $random = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $noReferensi = $kodeMerchant . '-' . $datePart . '-' . $random;
                } while (self::where('no_referensi', $noReferensi)->exists());

                $model->no_referensi = $noReferensi;
            }
        });
    }

    /**
     * Relation: Transaksi belongs to Merchant (UUID).
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }
}
