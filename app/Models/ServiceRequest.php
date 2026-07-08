<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'requested_by',
        'service_category_id',
        'title',
        'description',
        'urgency',
        'status',
        'schedule_preference',
        'location',
        'funding_preference',
        'budget_max',
        'notes',
        'paused_until',
        'pause_reason',
        'matched_provider_id',
    ];

    protected function casts(): array
    {
        return [
            'schedule_preference' => 'array',
            'budget_max' => 'decimal:2',
            'paused_until' => 'datetime',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function matchedProvider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'matched_provider_id');
    }
}