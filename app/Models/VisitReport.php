<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'provider_id',
        'checklist_completed',
        'notes',
        'photos',
        'documents',
        'signature',
        'service_outcome',
        'recommended_next_action',
        'mood',
        'appetite',
        'mobility',
        'engagement',
        'hydration',
        'loneliness_signs',
        'environmental_concerns',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'blood_glucose',
        'temperature',
        'heart_rate',
        'oxygen_saturation',
        'weight',
        'pain_level',
        'cognitive_status',
        'is_family_summary_generated',
        'family_summary',
    ];

    protected function casts(): array
    {
        return [
            'checklist_completed' => 'array',
            'photos' => 'array',
            'documents' => 'array',
            'temperature' => 'decimal:1',
            'weight' => 'decimal:2',
            'is_family_summary_generated' => 'boolean',
        ];
    }

    public function intervention(): BelongsTo
    {
        return $this->belongsTo(Intervention::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}