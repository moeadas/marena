<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InterventionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional(0.6)->paragraph(),
            'scheduled_at' => $this->faker->dateTimeBetween('-3 months', '+1 month'),
            'duration_minutes' => $this->faker->randomElement([30, 45, 60, 90, 120]),
            'status' => $this->faker->randomElement(['scheduled', 'in_progress', 'completed', 'completed', 'missed', 'cancelled']),
            'service_mode' => $this->faker->randomElement(['home_visit', 'home_visit', 'tele_support', 'on_site']),
            'address' => $this->faker->optional(0.7)->streetAddress(),
            'notes' => $this->faker->optional(0.4)->paragraph(),
            'has_issue' => $this->faker->boolean(15),
            'issue_description' => null,
            'funding_info' => null,
        ];
    }
}