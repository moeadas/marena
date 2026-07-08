<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            BeneficiariesSeeder::class,
            ProvidersAndCompanySeeder::class,
            ServiceCategoriesSeeder::class,
            ServicesSeeder::class,
            ProviderAvailabilitySeeder::class,
            CareCirclesInterventionsSeeder::class,
            MessagingAlertsRemindersSeeder::class,
        ]);
    }
}