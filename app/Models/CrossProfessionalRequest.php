<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrossProfessionalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'from_provider_id',
        'to_provider_id',
        'title',
        'description',
        'type',
        'status',
        'metadata',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'responded_at' => 'datetime',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function fromProvider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'from_provider_id');
    }

    public function toProvider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'to_provider_id');
    }
}