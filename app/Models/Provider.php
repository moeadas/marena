<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'profession',
        'specialty',
        'company_name',
        'is_independent',
        'company_id',
        'registration_number',
        'licence_number',
        'address',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'service_area',
        'verification_status',
        'verified_at',
        'verified_by',
        'verification_notes',
        'documents',
        'rating_avg',
        'rating_count',
        'completion_rate',
        'response_time_avg',
        'trust_markers',
    ];

    protected function casts(): array
    {
        return [
            'is_independent' => 'boolean',
            'verified_at' => 'datetime',
            'documents' => 'array',
            'rating_avg' => 'decimal:2',
            'trust_markers' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(ProviderAvailability::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProviderReview::class);
    }

    public function visitReports(): HasMany
    {
        return $this->hasMany(VisitReport::class);
    }

    public function crossProfessionalRequestsFrom(): HasMany
    {
        return $this->hasMany(CrossProfessionalRequest::class, 'from_provider_id');
    }

    public function crossProfessionalRequestsTo(): HasMany
    {
        return $this->hasMany(CrossProfessionalRequest::class, 'to_provider_id');
    }

    // Get beneficiaries through care circles (via user_id)
    public function careCircleBeneficiaries()
    {
        return Beneficiary::whereHas('careCircles', function ($q) {
            $q->where('user_id', $this->user_id)->where('member_type', 'provider');
        });
    }

    // Check if provider is in any care circle
    public function scopeInCareCircleOf($query, $caregiverUserId)
    {
        $beneficiaryIds = \App\Models\CareCircle::where('user_id', $caregiverUserId)
            ->where('member_type', 'caregiver')
            ->where('status', 'active')
            ->pluck('beneficiary_id');

        return $query->whereIn('user_id', function ($subq) use ($beneficiaryIds) {
            $subq->select('user_id')
                ->from('care_circles')
                ->whereIn('beneficiary_id', $beneficiaryIds)
                ->where('member_type', 'provider');
        });
    }
}