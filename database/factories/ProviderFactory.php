<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'profession' => 'nurse',
            'specialty' => $this->faker->optional(0.4)->word(),
            'company_name' => null,
            'is_independent' => true,
            'registration_number' => $this->faker->numerify('##########'),
            'licence_number' => $this->faker->optional(0.5)->numerify('######'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(43, 50),
            'longitude' => $this->faker->longitude(-1, 5),
            'service_area' => $this->faker->randomElement(['Paris 15e', 'Boulogne-Billancourt', 'Issy-les-Moulineaux', 'Neuilly-sur-Seine']),
            'verification_status' => $this->faker->randomElement(['pending', 'under_review', 'approved', 'approved']),
            'verified_at' => null,
            'verification_notes' => null,
            'documents' => [],
            'rating_avg' => $this->faker->randomFloat(2, 3, 5),
            'rating_count' => $this->faker->numberBetween(0, 50),
            'completion_rate' => $this->faker->numberBetween(70, 100),
            'response_time_avg' => $this->faker->numberBetween(15, 120),
            'trust_markers' => [],
        ];
    }
}