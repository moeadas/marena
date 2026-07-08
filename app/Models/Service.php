<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'service_category_id',
        'title',
        'description',
        'funding_type',
        'base_price',
        'reimbursement_amount',
        'beneficiary_remainder',
        'duration_minutes',
        'funding_notes',
        'checklist_template',
        'notes_template',
        'required_documents',
        'is_predefined',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'reimbursement_amount' => 'decimal:2',
            'beneficiary_remainder' => 'decimal:2',
            'checklist_template' => 'array',
            'notes_template' => 'array',
            'required_documents' => 'array',
            'is_predefined' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }
}