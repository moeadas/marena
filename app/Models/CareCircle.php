<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareCircle extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'user_id',
        'member_type',
        'relationship',
        'permissions',
        'status',
        'invited_at',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
            'invited_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Alias for backward compatibility
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}