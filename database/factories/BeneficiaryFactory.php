<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeneficiaryFactory extends Factory
{
    public function definition(): array
    {
        $height = $this->faker->randomFloat(2, 150, 190);
        $weight = $this->faker->randomFloat(2, 50, 100);
        $bmi = round($weight / (($height / 100) ** 2), 2);

        return [
            'date_of_birth' => $this->faker->dateTimeBetween('-90 years', '-65 years')->format('Y-m-d'),
            'national_health_insurance_number' => $this->faker->numerify('#############'),
            'height' => $height,
            'weight' => $weight,
            'bmi' => $bmi,
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'country' => 'FR',
            'latitude' => $this->faker->latitude(43, 50),
            'longitude' => $this->faker->longitude(-1, 5),
            'health_insurance' => $this->faker->randomElement(['MGEN', 'Harmonie Mutuelle', 'Allianz', 'AXA', 'CNM']),
            'retirement_fund' => $this->faker->randomElement(['CNAV', 'AGIRC-ARRCO', 'RSI', 'CNRACL']),
            'employment_status' => $this->faker->randomElement(['retired', 'retired', 'retired', 'inactive']),
            'family_status' => $this->faker->randomElement(['widowed', 'widowed', 'divorced', 'single']),
            'important_life_events' => $this->faker->optional(0.7)->paragraph(),
            'preferences' => $this->faker->optional(0.6)->paragraph(),
            'allergies_warnings' => $this->faker->optional(0.4)->paragraph(),
            'communication_mode' => $this->faker->randomElement(['app', 'phone', 'email', 'sms']),
            'consent_settings' => ['share_data' => true, 'receive_alerts' => true],
            'autonomy_level' => $this->faker->randomElement(['independent', 'slight_help', 'moderate_help', 'significant_help']),
        ];
    }
}