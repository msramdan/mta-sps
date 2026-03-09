<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenagihanDokumen extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'penagihan_dokumen';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'penagihan_id',
        'jenis_dokumen',
        'is_checked',
        'file_path',
        'file_name',
        'uploaded_at',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'is_checked' => 'boolean',
            'uploaded_at' => 'datetime',
        ];
    }

    public function penagihan(): BelongsTo
    {
        return $this->belongsTo(Penagihan::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getLabelAttribute(): string
    {
        return config("penagihan.jenis_dokumen.{$this->jenis_dokumen}", $this->jenis_dokumen);
    }
}
