<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenagihanFee extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penagihan_fee';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'penagihan_id',
        'keterangan',
        'nominal',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
        ];
    }

    public function penagihan(): BelongsTo
    {
        return $this->belongsTo(Penagihan::class);
    }
}
