<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VisitReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'checklist_completed' => [
                'Arrival and greeting' => true,
                'Vital signs checked' => true,
                'Care provided' => true,
                'Beneficiary wellbeing assessed' => true,
                'Next visit scheduled' => true,
            ],
            'notes' => $this->faker->paragraph(),
            'photos' => [],
            'documents' => [],
            'signature' => null,
            'service_outcome' => $this->faker->randomElement(['fully_completed', 'fully_completed', 'partially_completed', 'rescheduled']),
            'recommended_next_action' => $this->faker->optional(0.5)->sentence(),
            'mood' => $this->faker->randomElement(['good', 'good', 'neutral', 'low']),
            'appetite' => $this->faker->randomElement(['good', 'good', 'medium', 'low']),
            'mobility' => $this->faker->randomElement(['good', 'good', 'limited', 'assisted']),
            'engagement' => $this->faker->randomElement(['active', 'responsive', 'responsive', 'passive']),
            'hydration' => $this->faker->randomElement(['good', 'adequate', 'adequate', 'low']),
            'loneliness_signs' => $this->faker->optional(0.3)->sentence(),
            'environmental_concerns' => $this->faker->optional(0.2)->sentence(),
            'blood_pressure_systolic' => $this->faker->optional(0.5)->numberBetween(110, 150),
            'blood_pressure_diastolic' => $this->faker->optional(0.5)->numberBetween(70, 95),
            'blood_glucose' => $this->faker->optional(0.3)->numberBetween(80, 180),
            'temperature' => $this->faker->optional(0.4)->randomFloat(1, 36, 38),
            'heart_rate' => $this->faker->optional(0.4)->numberBetween(60, 90),
            'oxygen_saturation' => $this->faker->optional(0.3)->numberBetween(92, 99),
            'weight' => $this->faker->optional(0.3)->randomFloat(2, 50, 95),
            'pain_level' => $this->faker->optional(0.3)->numberBetween(0, 7),
            'cognitive_status' => $this->faker->optional(0.3)->sentence(),
            'is_family_summary_generated' => $this->faker->boolean(30),
            'family_summary' => null,
        ];
    }
}