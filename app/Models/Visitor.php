<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'user_id',
        'nama_rs',
        'pic_rs',
        'posisi_pic',
        'no_telp_pic',
        'tanggal_visit',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_visit' => 'date',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** Sales Marketing yang melakukan kunjungan */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
