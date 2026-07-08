<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id',
        'name',
        'relationship',
        'phone',
        'email',
        'is_legal_representative',
        'is_primary_contact',
    ];

    protected function casts(): array
    {
        return [
            'is_legal_representative' => 'boolean',
            'is_primary_contact' => 'boolean',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }
}