<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmergencyContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'relationship' => $this->faker->randomElement(['child', 'sibling', 'spouse', 'parent', 'other']),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional(0.6)->safeEmail(),
            'is_legal_representative' => $this->faker->boolean(20),
            'is_primary_contact' => false,
        ];
    }
}