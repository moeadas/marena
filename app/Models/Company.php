<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'legal_form',
        'siret',
        'naf_code',
        'address',
        'city',
        'postal_code',
        'phone',
        'email',
        'legal_info',
        'documents',
        'verification_status',
        'verified_at',
        'verified_by',
        'structure_type',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'documents' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
}