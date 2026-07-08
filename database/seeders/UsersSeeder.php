<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $beneficiaryRole = Role::where('name', 'beneficiary')->first();
        $caregiverRole = Role::where('name', 'caregiver')->first();
        $providerRole = Role::where('name', 'provider')->first();
        $companyManagerRole = Role::where('name', 'company_manager')->first();
        $employeeRole = Role::where('name', 'employee')->first();

        // Admin
        User::create([
            'name' => 'Sarah Admin',
            'first_name' => 'Sarah',
            'last_name' => 'Admin',
            'email' => 'admin@marena.fr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
            'phone' => '+33601000000',
            'language' => 'fr',
            'status' => 'active',
            'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
            'accessibility_prefs' => ['font_size' => 'medium', 'contrast' => 'normal'],
        ]);

        // Beneficiaries
        $beneficiaries = [
            ['first_name' => 'Marguerite', 'last_name' => 'Dubois', 'email' => 'marguerite.dubois@example.fr', 'phone' => '+33611111111'],
            ['first_name' => 'Henri', 'last_name' => 'Lambert', 'email' => 'henri.lambert@example.fr', 'phone' => '+33611111112'],
            ['first_name' => 'Simone', 'last_name' => 'Roux', 'email' => 'simone.roux@example.fr', 'phone' => '+33611111113'],
        ];

        foreach ($beneficiaries as $b) {
            User::create([
                'name' => "{$b['first_name']} {$b['last_name']}",
                'first_name' => $b['first_name'],
                'last_name' => $b['last_name'],
                'email' => $b['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $beneficiaryRole->id,
                'phone' => $b['phone'],
                'phone_verified_at' => now(),
                'language' => 'fr',
                'status' => 'active',
                'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
                'accessibility_prefs' => ['font_size' => 'large', 'contrast' => 'high'],
            ]);
        }

        // Caregivers
        $caregivers = [
            ['first_name' => 'Julie', 'last_name' => 'Dubois', 'email' => 'julie.dubois@example.fr', 'phone' => '+33622222221'],
            ['first_name' => 'Pierre', 'last_name' => 'Lambert', 'email' => 'pierre.lambert@example.fr', 'phone' => '+33622222222'],
            ['first_name' => 'Claire', 'last_name' => 'Roux', 'email' => 'claire.roux@example.fr', 'phone' => '+33622222223'],
        ];

        foreach ($caregivers as $c) {
            User::create([
                'name' => "{$c['first_name']} {$c['last_name']}",
                'first_name' => $c['first_name'],
                'last_name' => $c['last_name'],
                'email' => $c['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $caregiverRole->id,
                'phone' => $c['phone'],
                'language' => 'fr',
                'status' => 'active',
                'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
            ]);
        }

        // Providers — 5 professionals
        $providers = [
            ['first_name' => 'Nadine', 'last_name' => 'Martin', 'email' => 'nadine.martin@soin-domicile.fr', 'phone' => '+33633333331'],
            ['first_name' => 'Olivier', 'last_name' => 'Bernard', 'email' => 'olivier.bernard@physio.fr', 'phone' => '+33633333332'],
            ['first_name' => 'Sophie', 'last_name' => 'Moreau', 'email' => 'sophie.moreau@aide-domicile.fr', 'phone' => '+33633333333'],
            ['first_name' => 'Dr. Jean', 'last_name' => 'Lefebvre', 'email' => 'jean.lefebvre@medecin.fr', 'phone' => '+33633333334'],
            ['first_name' => 'Camille', 'last_name' => 'Girard', 'email' => 'camille.girard@social.fr', 'phone' => '+33633333335'],
        ];

        foreach ($providers as $p) {
            User::create([
                'name' => "{$p['first_name']} {$p['last_name']}",
                'first_name' => $p['first_name'],
                'last_name' => $p['last_name'],
                'email' => $p['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $providerRole->id,
                'phone' => $p['phone'],
                'phone_verified_at' => now(),
                'language' => 'fr',
                'status' => 'active',
                'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
            ]);
        }

        // Company Manager
        User::create([
            'name' => 'Marc Durand',
            'first_name' => 'Marc',
            'last_name' => 'Durand',
            'email' => 'marc.durand@auxiliaire-pro.fr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role_id' => $companyManagerRole->id,
            'phone' => '+33644444441',
            'phone_verified_at' => now(),
            'language' => 'fr',
            'status' => 'active',
            'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
        ]);

        // Employees
        $employees = [
            ['first_name' => 'Laura', 'last_name' => 'Petit', 'email' => 'laura.petit@auxiliaire-pro.fr', 'phone' => '+33644444442'],
            ['first_name' => 'Thomas', 'last_name' => 'Roux', 'email' => 'thomas.roux@auxiliaire-pro.fr', 'phone' => '+33644444443'],
        ];

        foreach ($employees as $e) {
            User::create([
                'name' => "{$e['first_name']} {$e['last_name']}",
                'first_name' => $e['first_name'],
                'last_name' => $e['last_name'],
                'email' => $e['email'],
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role_id' => $employeeRole->id,
                'phone' => $e['phone'],
                'language' => 'fr',
                'status' => 'active',
                'notification_prefs' => ['email' => true, 'sms' => true, 'push' => true],
            ]);
        }
    }
}