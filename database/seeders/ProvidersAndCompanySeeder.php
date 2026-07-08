<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProvidersAndCompanySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@marena.fr')->first();

        // Company
        $manager = User::where('email', 'marc.durand@auxiliaire-pro.fr')->first();
        $company = Company::create([
            'user_id' => $manager->id,
            'name' => 'Auxiliaire Pro Paris',
            'legal_form' => 'SARL',
            'siret' => '81234567800015',
            'naf_code' => '8810A',
            'address' => '24 Rue de la Convention',
            'city' => 'Paris',
            'postal_code' => '75015',
            'phone' => '+33145678900',
            'email' => 'contact@auxiliaire-pro.fr',
            'legal_info' => 'SARL au capital de 50 000 €. RCS Paris 812 345 678.',
            'documents' => ['insurance' => 'documents/insurance_2024.pdf', 'kbis' => 'documents/kbis.pdf'],
            'verification_status' => 'approved',
            'verified_at' => now()->subDays(60),
            'verified_by' => $admin->id,
            'structure_type' => 'SAAD',
        ]);

        $employees = User::where('email', 'like', '%@auxiliaire-pro.fr')->where('email', '!=', 'manager@auxiliaire-pro.fr')->get();

        // Providers
        $providerUsers = User::whereHas('role', fn($q) => $q->where('name', 'provider'))->get();

        $providerData = [
            // Nadine Martin — Nurse
            [
                'user_email' => 'nadine.martin@soin-domicile.fr',
                'profession' => 'nurse',
                'specialty' => 'Soins infirmiers à domicile',
                'company_name' => null,
                'is_independent' => true,
                'company_id' => null,
                'registration_number' => '1234567890',
                'licence_number' => 'ADELI751234',
                'address' => '10 Rue de Sèvres',
                'city' => 'Paris',
                'postal_code' => '75006',
                'latitude' => 48.8494,
                'longitude' => 2.3256,
                'service_area' => 'Paris 5e, 6e, 7e, 14e, 15e',
                'verification_status' => 'approved',
                'verified_at' => now()->subDays(90),
                'verified_by' => $admin->id,
                'verification_notes' => 'RPPS vérifié, ADELI validé, diplôme d\'État infirmier confirmé.',
                'documents' => ['diploma' => 'documents/nadine_diploma.pdf', 'rpps' => 'documents/nadine_rpps.pdf', 'insurance' => 'documents/nadine_insurance.pdf'],
                'rating_avg' => 4.80,
                'rating_count' => 23,
                'completion_rate' => 96,
                'response_time_avg' => 20,
                'trust_markers' => ['verified_badge', 'documents_validated', 'background_checked'],
            ],
            // Olivier Bernard — Physiotherapist
            [
                'user_email' => 'olivier.bernard@physio.fr',
                'profession' => 'physiotherapist',
                'specialty' => 'Rééducation et réadaptation',
                'company_name' => null,
                'is_independent' => true,
                'company_id' => null,
                'registration_number' => '2345678901',
                'licence_number' => 'ADELI752345',
                'address' => '5 Rue d\'Assas',
                'city' => 'Paris',
                'postal_code' => '75006',
                'latitude' => 48.8525,
                'longitude' => 2.3268,
                'service_area' => 'Paris 5e, 6e, 14e, 15e',
                'verification_status' => 'approved',
                'verified_at' => now()->subDays(120),
                'verified_by' => $admin->id,
                'verification_notes' => 'DE MKDE validé, ADELI confirmé.',
                'documents' => ['diploma' => 'documents/olivier_diploma.pdf', 'adelei' => 'documents/olivier_adeli.pdf'],
                'rating_avg' => 4.60,
                'rating_count' => 18,
                'completion_rate' => 92,
                'response_time_avg' => 35,
                'trust_markers' => ['verified_badge', 'documents_validated'],
            ],
            // Sophie Moreau — Home care assistant (linked to company)
            [
                'user_email' => 'sophie.moreau@aide-domicile.fr',
                'profession' => 'home_care_assistant',
                'specialty' => 'Aide à la vie quotidienne',
                'company_name' => 'Auxiliaire Pro Paris',
                'is_independent' => false,
                'company_id' => $company->id,
                'registration_number' => null,
                'licence_number' => null,
                'address' => '24 Rue de la Convention',
                'city' => 'Paris',
                'postal_code' => '75015',
                'latitude' => 48.8412,
                'longitude' => 2.2986,
                'service_area' => 'Paris 15e, 14e, Boulogne-Billancourt',
                'verification_status' => 'approved',
                'verified_at' => now()->subDays(45),
                'verified_by' => $admin->id,
                'verification_notes' => 'Salariée d\'Auxiliaire Pro Paris. CAS validé.',
                'documents' => ['cas' => 'documents/sophie_cas.pdf'],
                'rating_avg' => 4.40,
                'rating_count' => 12,
                'completion_rate' => 88,
                'response_time_avg' => 45,
                'trust_markers' => ['verified_badge', 'company_verified'],
            ],
            // Dr. Jean Lefebvre — Physician
            [
                'user_email' => 'jean.lefebvre@medecin.fr',
                'profession' => 'physician',
                'specialty' => 'Médecine générale / Gériatrie',
                'company_name' => null,
                'is_independent' => true,
                'company_id' => null,
                'registration_number' => '3456789012',
                'licence_number' => 'ADELI753456',
                'address' => '32 Rue du Bac',
                'city' => 'Paris',
                'postal_code' => '75007',
                'latitude' => 48.8542,
                'longitude' => 2.3247,
                'service_area' => 'Paris 6e, 7e, 15e, Issy-les-Moulineaux',
                'verification_status' => 'approved',
                'verified_at' => now()->subDays(200),
                'verified_by' => $admin->id,
                'verification_notes' => 'Doctorat en médecine validé, RPPS confirmé, Conseil de l\'Ordre vérifié.',
                'documents' => ['diploma' => 'documents/jean_diploma.pdf', 'rpps' => 'documents/jean_rpps.pdf', 'order' => 'documents/jean_order.pdf'],
                'rating_avg' => 4.90,
                'rating_count' => 31,
                'completion_rate' => 98,
                'response_time_avg' => 15,
                'trust_markers' => ['verified_badge', 'documents_validated', 'background_checked', 'order_member'],
            ],
            // Camille Girard — Social worker
            [
                'user_email' => 'camille.girard@social.fr',
                'profession' => 'social_worker',
                'specialty' => 'Assistance sociale et coordination de parcours',
                'company_name' => null,
                'is_independent' => true,
                'company_id' => null,
                'registration_number' => '4567890123',
                'licence_number' => 'ADELI754567',
                'address' => '18 Rue de Vaugirard',
                'city' => 'Paris',
                'postal_code' => '75006',
                'latitude' => 48.8467,
                'longitude' => 2.3361,
                'service_area' => 'Paris 5e, 6e, 7e, 14e, 15e',
                'verification_status' => 'approved',
                'verified_at' => now()->subDays(75),
                'verified_by' => $admin->id,
                'verification_notes' => 'Diplôme d\'État d\'assistant social validé, ADELI confirmé.',
                'documents' => ['diploma' => 'documents/camille_diploma.pdf', 'adeli' => 'documents/camille_adeli.pdf'],
                'rating_avg' => 4.70,
                'rating_count' => 15,
                'completion_rate' => 94,
                'response_time_avg' => 30,
                'trust_markers' => ['verified_badge', 'documents_validated'],
            ],
        ];

        foreach ($providerData as $pd) {
            $userEmail = $pd['user_email'];
            unset($pd['user_email']);
            $user = User::where('email', $userEmail)->first();
            Provider::create(array_merge(['user_id' => $user->id], $pd));
        }
    }
}