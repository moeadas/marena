<?php

namespace Database\Seeders;

use App\Models\ProviderAvailability;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderAvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $providers = Provider::all();

        $defaultSchedule = [
            ['day' => 'monday', 'start' => '08:00', 'end' => '18:00'],
            ['day' => 'tuesday', 'start' => '08:00', 'end' => '18:00'],
            ['day' => 'wednesday', 'start' => '08:00', 'end' => '18:00'],
            ['day' => 'thursday', 'start' => '08:00', 'end' => '18:00'],
            ['day' => 'friday', 'start' => '08:00', 'end' => '17:00'],
            ['day' => 'saturday', 'start' => '09:00', 'end' => '13:00'],
            ['day' => 'sunday', 'start' => '00:00', 'end' => '00:00'],
        ];

        foreach ($providers as $provider) {
            foreach ($defaultSchedule as $s) {
                ProviderAvailability::create([
                    'provider_id' => $provider->id,
                    'day_of_week' => $s['day'],
                    'start_time' => $s['start'],
                    'end_time' => $s['end'],
                    'is_available' => $s['start'] !== '00:00',
                    'is_recurring' => true,
                    'specific_date' => null,
                ]);
            }
        }
    }
}