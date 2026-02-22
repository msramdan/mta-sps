<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTokenB2b extends Model
{
    use HasFactory;

    protected $table = 'log_token_b2b';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'header',
        'payload',
        'response',
        'processing_time',
        'is_success',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'is_success' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
