<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'name' => "$firstName $lastName",
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'phone' => $this->faker->phoneNumber(),
            'language' => 'fr',
            'status' => 'active',
            'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
            'accessibility_prefs' => ['font_size' => 'medium', 'contrast' => 'normal'],
        ];
    }
}