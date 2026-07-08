<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'legal_form' => $this->faker->randomElement(['SARL', 'SAS', 'Association', 'SCOP', 'EURL']),
            'siret' => $this->faker->numerify('###############'),
            'naf_code' => $this->faker->numerify('######'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'legal_info' => $this->faker->optional(0.7)->paragraph(),
            'documents' => [],
            'verification_status' => $this->faker->randomElement(['pending', 'under_review', 'approved']),
            'verified_at' => null,
            'structure_type' => $this->faker->randomElement(['SAP', 'SAAD', 'SSIAD', 'HAD', 'CCAS']),
        ];
    }
}