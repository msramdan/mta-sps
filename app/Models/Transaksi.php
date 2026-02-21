<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'jumlah_diterima',
        'beban_biaya',
        'status',
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
            'jumlah_diterima' => 'decimal:2',
            'beban_biaya' => 'string',
            'status' => 'string',
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

    /** Fee: Nobu 0,7% + QRIN Rp 500 flat. */
    private const FEE_PERCENT = 0.007;
    private const FEE_FLAT = 500;

    /**
     * Charge to Merchant: total bayar dikurangi 0,7% + Rp 500.
     * Input: jumlah_dibayar (pelanggan bayar). Output: biaya, jumlah_diterima.
     *
     * @return array{biaya: float, jumlah_diterima: float}
     */
    public static function hitungBiayaDanDiterima(float $jumlahDibayar): array
    {
        $biaya = round($jumlahDibayar * self::FEE_PERCENT + self::FEE_FLAT, 2);
        $jumlahDiterima = round($jumlahDibayar - $biaya, 2);
        if ($jumlahDiterima < 0) {
            $jumlahDiterima = 0.0;
        }
        return ['biaya' => $biaya, 'jumlah_diterima' => $jumlahDiterima];
    }

    /**
     * Charge to Pelanggan: merchant terima bersih, hitung pelanggan bayar X.
     * X − (0,7%×X + 500) = jumlah_diterima → X = (jumlah_diterima + 500) / 0,993.
     * Dibulatkan ke atas ke rupiah penuh agar merchant dapat minimal jumlah_diterima.
     *
     * @return array{jumlah_dibayar: float, biaya: float, jumlah_diterima: float}
     */
    public static function hitungDariJumlahDiterima(float $jumlahDiterima): array
    {
        $x = ($jumlahDiterima + self::FEE_FLAT) / (1 - self::FEE_PERCENT);
        $jumlahDibayar = (float) (int) ceil($x); // bulatkan ke atas ke rupiah penuh (contoh: 10.574,02 → 10.575)
        $biaya = round($jumlahDibayar * self::FEE_PERCENT + self::FEE_FLAT, 2);
        $diterima = round($jumlahDibayar - $biaya, 2);
        return [
            'jumlah_dibayar' => $jumlahDibayar,
            'biaya' => $biaya,
            'jumlah_diterima' => $diterima,
        ];
    }

    /**
     * Relation: Transaksi belongs to Merchant (UUID).
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function logGenerateQrs(): HasMany
    {
        return $this->hasMany(LogGenerateQr::class, 'transaksi_id');
    }

    public function logCallbacks(): HasMany
    {
        return $this->hasMany(LogCallback::class, 'transaksi_id');
    }
}
