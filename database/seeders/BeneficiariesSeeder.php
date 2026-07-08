<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeneficiariesSeeder extends Seeder
{
    public function run(): void
    {
        $beneficiaryUsers = User::whereHas('role', fn($q) => $q->where('name', 'beneficiary'))->get();

        $data = [
            // Marguerite Dubois — 82, slight help, lives alone
            [
                'date_of_birth' => '1943-03-15',
                'national_health_insurance_number' => '2140321150042',
                'height' => 162,
                'weight' => 58,
                'bmi' => 22.10,
                'address' => '15 Rue des Lilas, Apt 3',
                'city' => 'Paris',
                'postal_code' => '75015',
                'country' => 'FR',
                'latitude' => 48.8412,
                'longitude' => 2.2986,
                'health_insurance' => 'MGEN',
                'retirement_fund' => 'CNAV',
                'employment_status' => 'retired',
                'family_status' => 'widowed',
                'important_life_events' => 'Veuve depuis 2019. Deux enfants qui vivent loin. Ancienne institutrice.',
                'preferences' => 'Préfère les femmes soignantes. Aime la lecture et la musique classique. Visites le matin de préférence.',
                'allergies_warnings' => 'Allergie à la pénicilline. Régime sans sel.',
                'communication_mode' => 'app',
                'consent_settings' => ['share_data' => true, 'receive_alerts' => true, 'family_access' => true],
                'autonomy_level' => 'slight_help',
                'emergency' => [
                    ['name' => 'Julie Dubois', 'relationship' => 'child', 'phone' => '+33622222221', 'email' => 'julie.dubois@example.fr', 'is_legal_representative' => false, 'is_primary_contact' => true],
                ],
            ],
            // Henri Lambert — 78, moderate help
            [
                'date_of_birth' => '1947-07-22',
                'national_health_insurance_number' => '1470722150098',
                'height' => 175,
                'weight' => 82,
                'bmi' => 26.78,
                'address' => '42 Avenue Victor Hugo',
                'city' => 'Boulogne-Billancourt',
                'postal_code' => '92100',
                'country' => 'FR',
                'latitude' => 48.8398,
                'longitude' => 2.2497,
                'health_insurance' => 'Harmonie Mutuelle',
                'retirement_fund' => 'AGIRC-ARRCO',
                'employment_status' => 'retired',
                'family_status' => 'divorced',
                'important_life_events' => 'Divorcé depuis 2015. Un fils. Ancien ingénieur. Diabète type 2 diagnostiqué en 2020.',
                'preferences' => 'Préfère un contact téléphonique. Visites après-midi. Apprécie discuter de sport.',
                'allergies_warnings' => 'Diabète type 2. Hypertension. Éviter les sucreries.',
                'communication_mode' => 'phone',
                'consent_settings' => ['share_data' => true, 'receive_alerts' => true, 'family_access' => true],
                'autonomy_level' => 'moderate_help',
                'emergency' => [
                    ['name' => 'Pierre Lambert', 'relationship' => 'child', 'phone' => '+33622222222', 'email' => 'pierre.lambert@example.fr', 'is_legal_representative' => false, 'is_primary_contact' => true],
                ],
            ],
            // Simone Roux — 85, significant help
            [
                'date_of_birth' => '1940-11-08',
                'national_health_insurance_number' => '2401121150067',
                'height' => 158,
                'weight' => 52,
                'bmi' => 20.83,
                'address' => '8 Rue du Maréchal Joffre',
                'city' => 'Issy-les-Moulineaux',
                'postal_code' => '92130',
                'country' => 'FR',
                'latitude' => 48.8244,
                'longitude' => 2.2720,
                'health_insurance' => 'Allianz',
                'retirement_fund' => 'CNAV',
                'employment_status' => 'retired',
                'family_status' => 'widowed',
                'important_life_events' => 'Veuve depuis 2012. Petite fille Claire très présente. Ancienne infirmière. Démence débutante diagnostiquée en 2023.',
                'preferences' => 'Préfère sa petite-fille Claire comme contact principal. Visites matin. Aime les promenades au parc si possible.',
                'allergies_warnings' => 'Démence débutante. Risque de chute. Ne pas laisser seule dehors.',
                'communication_mode' => 'app',
                'consent_settings' => ['share_data' => true, 'receive_alerts' => true, 'family_access' => true],
                'autonomy_level' => 'significant_help',
                'emergency' => [
                    ['name' => 'Claire Roux', 'relationship' => 'child', 'phone' => '+33622222223', 'email' => 'claire.roux@example.fr', 'is_legal_representative' => true, 'is_primary_contact' => true],
                ],
            ],
        ];

        foreach ($beneficiaryUsers as $index => $user) {
            $d = $data[$index];
            $emergencyData = $d['emergency'];
            unset($d['emergency']);

            $beneficiary = Beneficiary::create(array_merge(['user_id' => $user->id], $d));

            foreach ($emergencyData as $ec) {
                EmergencyContact::create(array_merge(
                    ['beneficiary_id' => $beneficiary->id],
                    $ec
                ));
            }
        }
    }
}