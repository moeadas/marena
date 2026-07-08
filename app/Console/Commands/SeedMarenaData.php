<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\Beneficiary;
use App\Models\Provider;
use App\Models\Company;
use App\Models\CareCircle;
use App\Models\Intervention;
use App\Models\VisitReport;
use App\Models\Service;
use App\Models\EmergencyContact;
use App\Models\Alert;
use App\Models\Reminder;
use App\Models\Document;
use App\Models\ServiceRequest;
use App\Models\CrossProfessionalRequest;
use App\Models\Complaint;
use App\Models\ProviderAvailability;
use App\Models\ProviderReview;
use App\Models\Subscription;
use App\Models\ConsentLog;
use App\Models\AuditLog;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class SeedMarenaData extends Command
{
    protected $signature = 'marena:seed {--fresh}';
    protected $description = 'Seed MARÉNA Care with comprehensive dummy data';

    public function handle()
    {
        if ($this->option('fresh')) {
            $this->info('Freshing database...');
            // Truncate all tables
            \DB::statement('PRAGMA foreign_keys = OFF');
            $tables = [
                'visit_reports', 'cross_professional_requests', 'complaints',
                'provider_reviews', 'provider_availability', 'service_requests',
                'reminders', 'alerts', 'messages', 'conversations',
                'documents', 'interventions', 'care_circles', 'services',
                'service_categories', 'emergency_contacts', 'providers',
                'companies', 'beneficiaries', 'subscriptions',
                'consent_logs', 'audit_logs', 'backups', 'users', 'roles',
            ];
            foreach ($tables as $t) {
                \DB::table($t)->truncate();
            }
            \DB::statement('PRAGMA foreign_keys = ON');
        }

        $this->info('Seeding roles...');
        $roles = $this->seedRoles();

        $this->info('Seeding service categories...');
        $categories = $this->seedServiceCategories();

        $this->info('Seeding users...');
        $users = $this->seedUsers($roles);

        $this->info('Seeding beneficiaries...');
        $beneficiaries = $this->seedBeneficiaries($users);

        $this->info('Seeding emergency contacts...');
        $this->seedEmergencyContacts($beneficiaries);

        $this->info('Seeding providers...');
        $providers = $this->seedProviders($users);

        $this->info('Seeding company...');
        $company = $this->seedCompany($users);
        $this->seedCompanyEmployees($users, $roles, $company);

        $this->info('Seeding services...');
        $services = $this->seedServices($providers, $categories);

        $this->info('Seeding care circles...');
        $this->seedCareCircles($beneficiaries, $users, $providers);

        $this->info('Seeding interventions...');
        $interventions = $this->seedInterventions($beneficiaries, $providers, $services);

        $this->info('Seeding visit reports...');
        $this->seedVisitReports($interventions, $providers);

        $this->info('Seeding conversations and messages...');
        $this->seedMessages($users, $beneficiaries);

        $this->info('Seeding alerts...');
        $this->seedAlerts($beneficiaries, $interventions, $users);

        $this->info('Seeding reminders...');
        $this->seedReminders($beneficiaries, $users);

        $this->info('Seeding documents...');
        $this->seedDocuments($beneficiaries, $users);

        $this->info('Seeding service requests...');
        $this->seedServiceRequests($beneficiaries, $users, $categories);

        $this->info('Seeding cross-professional requests...');
        $this->seedCrossProfessionalRequests($beneficiaries, $providers);

        $this->info('Seeding complaints...');
        $this->seedComplaints($beneficiaries, $users);

        $this->info('Seeding provider availability...');
        $this->seedProviderAvailability($providers);

        $this->info('Seeding provider reviews...');
        $this->seedProviderReviews($providers, $users, $interventions);

        $this->info('Seeding subscriptions...');
        $this->seedSubscriptions($users);

        $this->info('Seeding consent logs...');
        $this->seedConsentLogs($users);

        $this->info('Seeding audit logs...');
        $this->seedAuditLogs($users);

        $this->info('✅ All dummy data seeded successfully!');
    }

    private function seedRoles()
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Administrator', 'description' => 'Platform control tower'],
            ['name' => 'beneficiary', 'label' => 'Beneficiary', 'description' => 'Person receiving care'],
            ['name' => 'caregiver', 'label' => 'Family Caregiver', 'description' => 'Family member coordinating care'],
            ['name' => 'provider', 'label' => 'Service Provider', 'description' => 'Professional care provider'],
            ['name' => 'company_manager', 'label' => 'Company Manager', 'description' => 'Home support company manager'],
            ['name' => 'employee', 'label' => 'Employee', 'description' => 'Field worker for company'],
        ];

        foreach ($roles as $r) {
            Role::create($r);
        }

        return Role::pluck('id', 'name');
    }

    private function seedServiceCategories()
    {
        $categories = [
            // Home Care Assistant
            ['name' => 'Housekeeping', 'slug' => 'housekeeping', 'profession' => 'home_care_assistant', 'icon' => 'home', 'subcategories' => ['Bedding', 'Floors', 'Bathroom', 'Kitchen', 'Laundry', 'Windows', 'Dusting', 'Waste disposal']],
            ['name' => 'Daily Living Assistance', 'slug' => 'daily-living', 'profession' => 'home_care_assistant', 'icon' => 'user', 'subcategories' => ['Morning assistance', 'Evening assistance', 'Getting out of bed', 'Going to bed', 'Dressing', 'Undressing', 'Diaper change', 'Toileting assistance', 'Personal hygiene', 'Hair care', 'Shaving', 'Nail care']],
            ['name' => 'Meals', 'slug' => 'meals', 'profession' => 'home_care_assistant', 'icon' => 'utensils', 'subcategories' => ['Meal preparation', 'Heating meals', 'Feeding assistance', 'Hydration monitoring', 'Grocery organization', 'Meal planning']],
            ['name' => 'Shopping', 'slug' => 'shopping', 'profession' => 'home_care_assistant', 'icon' => 'shopping-bag', 'subcategories' => []],
            ['name' => 'Administrative Assistance', 'slug' => 'admin-assistance', 'profession' => 'home_care_assistant', 'icon' => 'document', 'subcategories' => []],
            ['name' => 'Transportation', 'slug' => 'transportation', 'profession' => 'home_care_assistant', 'icon' => 'car', 'subcategories' => ['Medical appointment', 'Shopping', 'Administrative appointment', 'Leisure outing', 'Family visit', 'Café/Restaurant', 'Pharmacy']],
            ['name' => 'Accompaniment', 'slug' => 'accompaniment', 'profession' => 'home_care_assistant', 'icon' => 'users', 'subcategories' => ['Medical appointment', 'Leisure activities', 'Walking', 'Family visit', 'Religious service', 'Shopping assistance', 'Social activities']],
            ['name' => 'Gardening', 'slug' => 'gardening', 'profession' => 'home_care_assistant', 'icon' => 'leaf', 'subcategories' => ['Lawn mowing', 'Hedge trimming', 'Watering', 'Sweeping', 'Leaf collection', 'Weeding', 'Small garden maintenance']],
            ['name' => 'Small DIY', 'slug' => 'small-diy', 'profession' => 'home_care_assistant', 'icon' => 'tool', 'subcategories' => ['Change light bulb', 'Replace batteries', 'Internet box restart', 'Smoke detector battery', 'Curtain installation', 'Hang picture', 'Fill holes', 'Tighten furniture', 'Assemble furniture', 'Replace door handle', 'Install shelf']],
            ['name' => 'Temporary Home Supervision', 'slug' => 'home-supervision', 'profession' => 'home_care_assistant', 'icon' => 'shield', 'subcategories' => ['Presence monitoring', 'Safety supervision', 'Night presence', 'Temporary monitoring after hospitalization']],
            ['name' => 'Pet Care', 'slug' => 'pet-care', 'profession' => 'home_care_assistant', 'icon' => 'heart', 'subcategories' => ['Feed pets', 'Dog walking', 'Clean litter', 'Grooming assistance', 'Veterinary appointment']],
            ['name' => 'Other (Home Care)', 'slug' => 'other-home-care', 'profession' => 'home_care_assistant', 'icon' => 'more', 'subcategories' => []],
            // Nurse
            ['name' => 'Personal Hygiene (Nurse)', 'slug' => 'nurse-hygiene', 'profession' => 'nurse', 'icon' => 'droplet', 'subcategories' => ['Bed bath', 'Sink bath', 'Shower', 'Hair washing', 'Oral care', 'Skin care']],
            ['name' => 'Wound Care', 'slug' => 'wound-care', 'profession' => 'nurse', 'icon' => 'bandage', 'subcategories' => ['Dressing change', 'Pressure ulcer care', 'Drain care', 'Surgical wound', 'Compression bandage', 'Suture care']],
            ['name' => 'Medication', 'slug' => 'medication', 'profession' => 'nurse', 'icon' => 'pill', 'subcategories' => ['Medication administration', 'Pill organizer preparation', 'Injection', 'IV treatment', 'Medication monitoring']],
            ['name' => 'Clinical Monitoring', 'slug' => 'clinical-monitoring', 'profession' => 'nurse', 'icon' => 'activity', 'subcategories' => ['Blood pressure', 'Blood glucose', 'Temperature', 'Oxygen saturation', 'Pulse', 'Weight', 'Respiratory rate']],
            ['name' => 'Sampling', 'slug' => 'sampling', 'profession' => 'nurse', 'icon' => 'test-tube', 'subcategories' => ['Blood sample', 'Urine sample', 'Other sample']],
            ['name' => 'Prevention', 'slug' => 'prevention', 'profession' => 'nurse', 'icon' => 'shield', 'subcategories' => ['Hydration monitoring', 'Nutrition monitoring', 'Fall prevention', 'Skin monitoring', 'Pressure ulcer prevention']],
            ['name' => 'Coordination (Nurse)', 'slug' => 'nurse-coordination', 'profession' => 'nurse', 'icon' => 'phone', 'subcategories' => ['Contact physician', 'Contact physiotherapist', 'Contact caregiver', 'Prescription renewal request', 'Care coordination']],
            ['name' => 'Other (Nurse)', 'slug' => 'other-nurse', 'profession' => 'nurse', 'icon' => 'more', 'subcategories' => []],
            // Physician
            ['name' => 'Consultation', 'slug' => 'consultation', 'profession' => 'physician', 'icon' => 'stethoscope', 'subcategories' => ['Initial consultation', 'Follow-up consultation', 'Emergency consultation']],
            ['name' => 'Clinical Assessment', 'slug' => 'clinical-assessment', 'profession' => 'physician', 'icon' => 'clipboard', 'subcategories' => ['General examination', 'Cardiovascular', 'Respiratory', 'Neurological', 'Cognitive assessment', 'Pain assessment']],
            ['name' => 'Prescriptions', 'slug' => 'prescriptions', 'profession' => 'physician', 'icon' => 'file-text', 'subcategories' => ['Medication', 'Blood tests', 'Imaging', 'Nursing care', 'Physiotherapy', 'Occupational therapy', 'Speech therapy', 'Dietitian']],
            ['name' => 'Treatment', 'slug' => 'treatment', 'profession' => 'physician', 'icon' => 'pill', 'subcategories' => ['Medication review', 'Pill organizer', 'Chronic disease monitoring', 'Post-operative care', 'Pressure ulcer treatment', 'Drain management']],
            ['name' => 'Prevention (Physician)', 'slug' => 'physician-prevention', 'profession' => 'physician', 'icon' => 'shield', 'subcategories' => ['Vaccination', 'Nutrition', 'Hydration', 'Fall prevention']],
            ['name' => 'Referrals', 'slug' => 'referrals', 'profession' => 'physician', 'icon' => 'arrow-right', 'subcategories' => ['Nurse', 'Physiotherapist', 'Occupational therapist', 'Speech therapist', 'Social worker', 'Psychologist', 'Dietitian']],
            ['name' => 'Other (Physician)', 'slug' => 'other-physician', 'profession' => 'physician', 'icon' => 'more', 'subcategories' => []],
            // Physiotherapist
            ['name' => 'Rehabilitation', 'slug' => 'rehabilitation', 'profession' => 'physiotherapist', 'icon' => 'activity', 'subcategories' => ['Muscle strengthening', 'Walking rehabilitation', 'Balance', 'Transfers', 'Respiratory rehabilitation', 'Joint mobility', 'Stretching', 'Functional exercises']],
            ['name' => 'Functional Assessment', 'slug' => 'functional-assessment', 'profession' => 'physiotherapist', 'icon' => 'clipboard', 'subcategories' => ['Walking', 'Pain', 'Mobility', 'Fall risk', 'Muscle strength']],
            ['name' => 'Education', 'slug' => 'education', 'profession' => 'physiotherapist', 'icon' => 'book', 'subcategories' => ['Home exercises', 'Family education', 'Prevention advice']],
            ['name' => 'Other (Physio)', 'slug' => 'other-physio', 'profession' => 'physiotherapist', 'icon' => 'more', 'subcategories' => []],
            // Occupational Therapist
            ['name' => 'Home Assessment', 'slug' => 'home-assessment', 'profession' => 'occupational_therapist', 'icon' => 'home', 'subcategories' => ['Accessibility', 'Safety', 'Fall prevention']],
            ['name' => 'Equipment', 'slug' => 'equipment', 'profession' => 'occupational_therapist', 'icon' => 'tool', 'subcategories' => ['Wheelchair', 'Walker', 'Grab bars', 'Shower chair', 'Transfer equipment']],
            ['name' => 'Functional Independence', 'slug' => 'functional-independence', 'profession' => 'occupational_therapist', 'icon' => 'user', 'subcategories' => ['Dressing', 'Bathing', 'Feeding', 'Kitchen activities', 'Cognitive aids']],
            ['name' => 'Home Adaptation', 'slug' => 'home-adaptation', 'profession' => 'occupational_therapist', 'icon' => 'building', 'subcategories' => ['Recommendations', 'Environmental modifications']],
            // Speech Therapist
            ['name' => 'Communication', 'slug' => 'communication', 'profession' => 'speech_therapist', 'icon' => 'chat', 'subcategories' => ['Speech', 'Language', 'Voice']],
            ['name' => 'Swallowing', 'slug' => 'swallowing', 'profession' => 'speech_therapist', 'icon' => 'utensils', 'subcategories' => ['Swallowing assessment', 'Swallowing exercises', 'Diet recommendations']],
            ['name' => 'Cognitive Rehabilitation', 'slug' => 'cognitive-rehab', 'profession' => 'speech_therapist', 'icon' => 'brain', 'subcategories' => ['Memory', 'Attention', 'Executive functions']],
            // Social Worker
            ['name' => 'Administrative Support (Social)', 'slug' => 'social-admin', 'profession' => 'social_worker', 'icon' => 'document', 'subcategories' => ['Benefits', 'Housing', 'Financial aid', 'Insurance']],
            ['name' => 'Social Assessment', 'slug' => 'social-assessment', 'profession' => 'social_worker', 'icon' => 'clipboard', 'subcategories' => ['Family situation', 'Isolation', 'Resources']],
            ['name' => 'Care Coordination (Social)', 'slug' => 'social-coordination', 'profession' => 'social_worker', 'icon' => 'phone', 'subcategories' => ['Care plan', 'Service coordination', 'Institutional liaison']],
            ['name' => 'Rights & Advocacy', 'slug' => 'rights-advocacy', 'profession' => 'social_worker', 'icon' => 'shield', 'subcategories' => ['Legal protection', 'Disability rights', 'Social rights']],
        ];

        foreach ($categories as $i => $cat) {
            ServiceCategory::create(array_merge($cat, [
                'is_predefined' => true,
                'sort_order' => $i,
                'color' => '#2C5F5D',
            ]));
        }

        return ServiceCategory::pluck('id', 'slug');
    }

    private function seedUsers($roles)
    {
        $users = [];

        // Admin
        $users['admin'] = User::create([
            'first_name' => 'Sarah', 'last_name' => 'Admin',
            'name' => 'Sarah Admin',
            'email' => 'admin@marena.care',
            'password' => Hash::make('password123'),
            'role_id' => $roles['admin'],
            'status' => 'active',
            'language' => 'en',
            'phone' => '+33123456780',
        ]);

        // Beneficiaries
        $benData = [
            ['Marie', 'Dubois', 'marie@marena.care', '+33123456701', '1945-03-15', '12 Rue des Lilas, Paris 75014', 'Paris', '75014'],
            ['Henri', 'Martin', 'henri@marena.care', '+33123456702', '1938-07-22', '45 Avenue Victor Hugo, Lyon 69006', 'Lyon', '69006'],
            ['Suzanne', 'Bernard', 'suzanne@marena.care', '+33123456703', '1950-11-08', '8 Place Bellecour, Marseille 13001', 'Marseille', '13001'],
        ];

        foreach ($benData as $i => $d) {
            $users["beneficiary_$i"] = User::create([
                'first_name' => $d[0], 'last_name' => $d[1],
                'name' => "$d[0] $d[1]",
                'email' => $d[2], 'phone' => $d[3],
                'password' => Hash::make('password123'),
                'role_id' => $roles['beneficiary'],
                'status' => 'active',
                'language' => 'en',
            ]);
        }

        // Caregivers
        $cgData = [
            ['Sophie', 'Dubois', 'sophie@marena.care', '+33123456711', 'daughter'],
            ['Pierre', 'Martin', 'pierre@marena.care', '+33123456712', 'son'],
            ['Claire', 'Bernard', 'claire@marena.care', '+33123456713', 'spouse'],
        ];

        foreach ($cgData as $i => $d) {
            $users["caregiver_$i"] = User::create([
                'first_name' => $d[0], 'last_name' => $d[1],
                'name' => "$d[0] $d[1]",
                'email' => $d[2], 'phone' => $d[3],
                'password' => Hash::make('password123'),
                'role_id' => $roles['caregiver'],
                'status' => 'active',
                'language' => 'en',
            ]);
        }

        // Providers
        $provData = [
            ['Nathalie', 'Roux', 'nathalie@marena.care', '+33123456721', 'nurse', 'Nurse', 'approved', 'RPPS: 12345678'],
            ['Thomas', 'Lefebvre', 'thomas@marena.care', '+33123456722', 'physiotherapist', 'Physiotherapist', 'approved', 'RPPS: 23456789'],
            ['Julie', 'Moreau', 'julie@marena.care', '+33123456723', 'home_care_assistant', 'Home Care Assistant', 'approved', 'ADELI: 34567890'],
            ['Dr. Jean', 'Petit', 'jean@marena.care', '+33123456724', 'physician', 'Physician', 'approved', 'RPPS: 45678901'],
            ['Marc', 'Girard', 'marc@marena.care', '+33123456725', 'social_worker', 'Social Worker', 'pending', 'ADELI: 56789012'],
        ];

        foreach ($provData as $i => $d) {
            $users["provider_$i"] = User::create([
                'first_name' => $d[0], 'last_name' => $d[1],
                'name' => "$d[0] $d[1]",
                'email' => $d[2], 'phone' => $d[3],
                'password' => Hash::make('password123'),
                'role_id' => $roles['provider'],
                'status' => $d[5] === 'approved' ? 'active' : 'pending',
                'language' => 'en',
            ]);
        }

        // Company Manager
        $users['company_manager'] = User::create([
            'first_name' => 'Isabelle', 'last_name' => 'Durand',
            'name' => 'Isabelle Durand',
            'email' => 'isabelle@marena.care',
            'phone' => '+33123456730',
            'password' => Hash::make('password123'),
            'role_id' => $roles['company_manager'],
            'status' => 'active',
            'language' => 'en',
        ]);

        return $users;
    }

    private function seedBeneficiaries($users)
    {
        $benData = [
            ['user_id' => $users['beneficiary_0']->id, 'date_of_birth' => '1945-03-15', 'address' => '12 Rue des Lilas, Paris 75014', 'city' => 'Paris', 'postal_code' => '75014', 'height' => 162, 'weight' => 58, 'health_insurance' => 'Harmonie Mutuelle', 'retirement_fund' => 'CNAV', 'employment_status' => 'Retired', 'family_status' => 'Widowed', 'important_life_events' => 'Husband passed away 2 years ago. Recent hip surgery.', 'preferences' => 'Prefers morning visits. Likes classical music. Enjoys walking in the park.', 'allergies_warnings' => 'Allergic to penicillin. Mild hypertension.', 'autonomy_level' => 'slight_help', 'communication_mode' => 'app'],
            ['user_id' => $users['beneficiary_1']->id, 'date_of_birth' => '1938-07-22', 'address' => '45 Avenue Victor Hugo, Lyon 69006', 'city' => 'Lyon', 'postal_code' => '69006', 'height' => 170, 'weight' => 72, 'health_insurance' => 'MGEN', 'retirement_fund' => 'AGIRC-ARRCO', 'employment_status' => 'Retired', 'family_status' => 'Married', 'important_life_events' => 'Parkinson diagnosis 3 years ago. Living with spouse.', 'preferences' => 'Prefers afternoon visits. Former teacher. Loves reading.', 'allergies_warnings' => 'Diabetes Type 2. Parkinson medication.', 'autonomy_level' => 'moderate_help', 'communication_mode' => 'app'],
            ['user_id' => $users['beneficiary_2']->id, 'date_of_birth' => '1950-11-08', 'address' => '8 Place Bellecour, Marseille 13001', 'city' => 'Marseille', 'postal_code' => '13001', 'height' => 165, 'weight' => 65, 'health_insurance' => 'Allianz', 'retirement_fund' => 'CARSAT', 'employment_status' => 'Retired', 'family_status' => 'Divorced', 'important_life_events' => 'Recently discharged from hospital after pneumonia.', 'preferences' => 'Prefers female caregivers. Enjoys social activities and outings.', 'allergies_warnings' => 'No known allergies.', 'autonomy_level' => 'significant_help', 'communication_mode' => 'phone'],
        ];

        $beneficiaries = [];
        foreach ($benData as $d) {
            $bmi = $d['height'] && $d['weight'] ? round($d['weight'] / pow($d['height'] / 100, 2), 1) : null;
            $beneficiaries[] = Beneficiary::create(array_merge($d, ['bmi' => $bmi, 'country' => 'FR']));
        }

        return $beneficiaries;
    }

    private function seedEmergencyContacts($beneficiaries)
    {
        $contacts = [
            [0, 'Sophie Dubois', 'Daughter', '+33123456711', 'sophie@marena.care', true, true],
            [0, 'Dr. Jean Petit', 'Physician', '+33123456724', 'jean@marena.care', false, false],
            [1, 'Pierre Martin', 'Son', '+33123456712', 'pierre@marena.care', true, true],
            [1, 'Claire Martin', 'Spouse', '+33123456713', null, false, false],
            [2, 'Claire Bernard', 'Spouse', '+33123456713', 'claire@marena.care', true, true],
        ];

        foreach ($contacts as $c) {
            EmergencyContact::create([
                'beneficiary_id' => $beneficiaries[$c[0]]->id,
                'name' => $c[1], 'relationship' => $c[2], 'phone' => $c[3],
                'email' => $c[4] ?? null, 'is_legal_representative' => $c[5],
                'is_primary_contact' => $c[6],
            ]);
        }
    }

    private function seedProviders($users)
    {
        $providers = [];
        $provData = [
            [0, 'nurse', 'Nurse', true, '123 Rue de la Santé, Paris 75015', 'Paris', '75015', 'Paris + suburbs', 'approved', 'RPPS: 12345678'],
            [1, 'physiotherapist', 'Physiotherapist', true, '78 Boulevard Sébastopol, Paris 75003', 'Paris', '75003', 'Paris center', 'approved', 'RPPS: 23456789'],
            [2, 'home_care_assistant', 'Home Care Assistant', true, '34 Rue du Faubourg, Lyon 69001', 'Lyon', '69001', 'Lyon + region', 'approved', 'ADELI: 34567890'],
            [3, 'physician', 'General Practitioner', true, '15 Rue de Rivoli, Paris 75001', 'Paris', '75001', 'Paris 1-7', 'approved', 'RPPS: 45678901'],
            [4, 'social_worker', 'Social Worker', true, '90 Place du Marché, Marseille 13002', 'Marseille', '13002', 'Marseille', 'pending', 'ADELI: 56789012'],
        ];

        foreach ($provData as $d) {
            $p = Provider::create([
                'user_id' => $users["provider_$d[0]"]->id,
                'profession' => $d[1], 'specialty' => $d[2],
                'is_independent' => $d[3],
                'address' => $d[4], 'city' => $d[5], 'postal_code' => $d[6],
                'service_area' => $d[7],
                'verification_status' => $d[8],
                'registration_number' => $d[9],
                'verified_at' => $d[8] === 'approved' ? now() : null,
                'verified_by' => $d[8] === 'approved' ? $users['admin']->id : null,
                'rating_avg' => $d[8] === 'approved' ? 4.5 + rand(0, 4) * 0.1 : 0,
                'rating_count' => $d[8] === 'approved' ? rand(5, 30) : 0,
                'completion_rate' => $d[8] === 'approved' ? rand(85, 99) : 0,
            ]);
            $providers[] = $p;
        }

        return $providers;
    }

    private function seedCompany($users)
    {
        return Company::create([
            'user_id' => $users['company_manager']->id,
            'name' => 'Aide & Care Services',
            'legal_form' => 'SARL',
            'siret' => '12345678900012',
            'address' => '25 Rue du Care, Paris 75011',
            'city' => 'Paris',
            'postal_code' => '75011',
            'phone' => '+33123456730',
            'email' => 'contact@aideetcare.fr',
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => $users['admin']->id,
            'structure_type' => 'SAAD',
        ]);
    }

    private function seedCompanyEmployees($users, $roles, $company)
    {
        $empData = [
            ['Laura', 'Simon', 'laura@marena.care', '+33123456731'],
            ['David', 'Lambert', 'david@marena.care', '+33123456732'],
        ];

        foreach ($empData as $d) {
            $user = User::create([
                'first_name' => $d[0], 'last_name' => $d[1],
                'name' => "$d[0] $d[1]",
                'email' => $d[2], 'phone' => $d[3],
                'password' => Hash::make('password123'),
                'role_id' => $roles['employee'],
                'status' => 'active',
            ]);
            Provider::create([
                'user_id' => $user->id,
                'profession' => 'home_care_assistant',
                'is_independent' => false,
                'company_id' => $company->id,
                'verification_status' => 'approved',
                'verified_at' => now(),
                'verified_by' => $users['admin']->id,
            ]);
        }
    }

    private function seedServices($providers, $categories)
    {
        $services = [];

        // Nurse services
        $nurseServices = [
            ['Medication Administration', 'medication', 'state_funded', 35, 30, 28, 2],
            ['Wound Care & Dressing', 'wound-care', 'partially_reimbursed', 25, 25, 18, 7],
            ['Blood Pressure Monitoring', 'clinical-monitoring', 'state_funded', 15, 20, 15, 5],
            ['Personal Hygiene Assistance', 'nurse-hygiene', 'mixed', 30, 45, 20, 25],
        ];

        foreach ($nurseServices as $s) {
            $services[] = Service::create([
                'provider_id' => $providers[0]->id,
                'service_category_id' => $categories[$s[1]] ?? null,
                'title' => $s[0],
                'funding_type' => $s[2],
                'base_price' => $s[3],
                'reimbursement_amount' => $s[4],
                'beneficiary_remainder' => $s[5],
                'duration_minutes' => $s[6],
                'checklist_template' => json_encode(['Hand washing', 'Prepare medication', 'Administer medication', 'Document', 'Report any issues']),
                'is_active' => true,
            ]);
        }

        // Physio services
        $physioServices = [
            ['Mobility Rehabilitation', 'rehabilitation', 'partially_reimbursed', 50, 40, 10, 45],
            ['Balance & Fall Prevention', 'functional-assessment', 'partially_reimbursed', 45, 35, 10, 40],
        ];
        foreach ($physioServices as $s) {
            $services[] = Service::create([
                'provider_id' => $providers[1]->id,
                'service_category_id' => $categories[$s[1]] ?? null,
                'title' => $s[0],
                'funding_type' => $s[2],
                'base_price' => $s[3],
                'reimbursement_amount' => $s[4],
                'beneficiary_remainder' => $s[5],
                'duration_minutes' => $s[6],
                'is_active' => true,
            ]);
        }

        // Home care services
        $homeCareServices = [
            ['Housekeeping - Full Clean', 'housekeeping', 'beneficiary_paid', 25, 0, 25, 120],
            ['Meal Preparation', 'meals', 'beneficiary_paid', 20, 0, 20, 60],
            ['Daily Living Assistance', 'daily-living', 'mixed', 22, 15, 7, 90],
            ['Transportation - Medical', 'transportation', 'partially_reimbursed', 15, 10, 5, 60],
        ];
        foreach ($homeCareServices as $s) {
            $services[] = Service::create([
                'provider_id' => $providers[2]->id,
                'service_category_id' => $categories[$s[1]] ?? null,
                'title' => $s[0],
                'funding_type' => $s[2],
                'base_price' => $s[3],
                'reimbursement_amount' => $s[4],
                'beneficiary_remainder' => $s[5],
                'duration_minutes' => $s[6],
                'is_active' => true,
            ]);
        }

        // Physician services
        $services[] = Service::create([
            'provider_id' => $providers[3]->id,
            'service_category_id' => $categories['consultation'] ?? null,
            'title' => 'Home Consultation',
            'funding_type' => 'state_funded',
            'base_price' => 25, 'reimbursement_amount' => 23, 'beneficiary_remainder' => 2,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        return $services;
    }

    private function seedCareCircles($beneficiaries, $users, $providers)
    {
        // Beneficiary 0 (Marie) - has caregiver Sophie, nurse, home care, physician
        CareCircle::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['caregiver_0']->id, 'member_type' => 'caregiver', 'relationship' => 'child', 'permissions' => json_encode(['view_only' => false, 'message_providers' => true, 'manage_schedule' => true, 'approve_services' => true, 'receive_alerts' => true]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['provider_0']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true, 'message_providers' => true, 'manage_schedule' => false, 'approve_services' => false, 'receive_alerts' => false]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['provider_2']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true, 'message_providers' => true, 'manage_schedule' => false, 'approve_services' => false, 'receive_alerts' => false]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['provider_3']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true, 'message_providers' => true, 'manage_schedule' => false, 'approve_services' => false, 'receive_alerts' => false]), 'status' => 'active']);

        // Beneficiary 1 (Henri) - has caregiver Pierre, physio
        CareCircle::create(['beneficiary_id' => $beneficiaries[1]->id, 'user_id' => $users['caregiver_1']->id, 'member_type' => 'caregiver', 'relationship' => 'child', 'permissions' => json_encode(['view_only' => false, 'message_providers' => true, 'manage_schedule' => true, 'approve_services' => true, 'receive_alerts' => true]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[1]->id, 'user_id' => $users['provider_1']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[1]->id, 'user_id' => $users['provider_0']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true]), 'status' => 'active']);

        // Beneficiary 2 (Suzanne) - has caregiver Claire
        CareCircle::create(['beneficiary_id' => $beneficiaries[2]->id, 'user_id' => $users['caregiver_2']->id, 'member_type' => 'caregiver', 'relationship' => 'spouse', 'permissions' => json_encode(['view_only' => false, 'message_providers' => true, 'manage_schedule' => true, 'approve_services' => true, 'receive_alerts' => true]), 'status' => 'active']);
        CareCircle::create(['beneficiary_id' => $beneficiaries[2]->id, 'user_id' => $users['provider_2']->id, 'member_type' => 'provider', 'permissions' => json_encode(['view_only' => true]), 'status' => 'active']);
    }

    private function seedInterventions($beneficiaries, $providers, $services)
    {
        $interventions = [];
        $statuses = ['scheduled', 'completed', 'completed', 'completed', 'missed', 'cancelled', 'scheduled', 'completed'];

        for ($i = 0; $i < 15; $i++) {
            $benIdx = $i % 3;
            $provIdx = $i % 5;
            $status = $statuses[$i % count($statuses)];
            $daysAgo = ($i < 5) ? $i + 1 : ($i - 4);
            $date = ($status === 'scheduled') ? now()->addDays(rand(1, 7))->setTime(rand(8, 17), rand(0, 50), 0) : now()->subDays($daysAgo)->setTime(rand(8, 17), rand(0, 50), 0);
            $service = $services[$i % count($services)] ?? null;

            $interventions[] = Intervention::create([
                'beneficiary_id' => $beneficiaries[$benIdx]->id,
                'provider_id' => $providers[$provIdx]->id,
                'service_id' => $service?->id,
                'title' => $service?->title ?? 'General Visit',
                'description' => 'Scheduled care visit',
                'scheduled_at' => $date,
                'duration_minutes' => $service?->duration_minutes ?? 60,
                'status' => $status,
                'service_mode' => 'home_visit',
                'address' => $beneficiaries[$benIdx]->address,
                'started_at' => $status === 'completed' ? $date : ($status === 'in_progress' ? now() : null),
                'completed_at' => $status === 'completed' ? $date->copy()->addMinutes($service?->duration_minutes ?? 60) : null,
                'cancelled_at' => $status === 'cancelled' ? $date : null,
                'cancel_reason' => $status === 'cancelled' ? 'Beneficiary not available' : null,
                'has_issue' => $status === 'missed' && rand(0, 1),
                'issue_description' => ($status === 'missed' && rand(0, 1)) ? 'Provider did not arrive' : null,
            ]);
        }

        return $interventions;
    }

    private function seedVisitReports($interventions, $providers)
    {
        foreach ($interventions as $i) {
            if ($i->status !== 'completed') continue;

            $reportData = [
                'intervention_id' => $i->id,
                'provider_id' => $i->provider_id,
                'service_outcome' => 'fully_completed',
                'notes' => 'Visit completed successfully. Patient was cooperative.',
                'mood' => ['good', 'neutral', 'low'][rand(0, 2)],
                'appetite' => ['good', 'medium', 'low'][rand(0, 2)],
                'mobility' => ['good', 'limited', 'assisted'][rand(0, 2)],
                'engagement' => ['active', 'responsive', 'passive'][rand(0, 2)],
                'hydration' => ['good', 'adequate', 'low'][rand(0, 2)],
                'checklist_completed' => json_encode(['Hand washing', 'Prepare medication', 'Administer medication', 'Document']),
            ];

            // Add vitals for nurse/physician visits
            if (in_array($i->provider->profession, ['nurse', 'physician'])) {
                $reportData['blood_pressure_systolic'] = rand(110, 150);
                $reportData['blood_pressure_diastolic'] = rand(65, 95);
                $reportData['blood_glucose'] = rand(70, 140);
                $reportData['heart_rate'] = rand(60, 90);
                $reportData['temperature'] = round(36.5 + rand(0, 10) / 10, 1);
                $reportData['oxygen_saturation'] = rand(92, 99);
                $reportData['weight'] = rand(55, 80) + rand(0, 9) / 10;
                $reportData['pain_level'] = rand(0, 5);
            }

            VisitReport::create($reportData);
        }
    }

    private function seedMessages($users, $beneficiaries)
    {
        // Conversation between caregiver 0 and provider 0 (nurse)
        $conv = Conversation::create([
            'subject' => 'Marie\'s care update',
            'type' => 'direct',
            'beneficiary_id' => $beneficiaries[0]->id,
            'participants' => json_encode([$users['caregiver_0']->id, $users['provider_0']->id]),
            'last_message_at' => now()->subHours(3),
        ]);

        Message::create(['conversation_id' => $conv->id, 'sender_id' => $users['provider_0']->id, 'content' => 'Hello Sophie, Marie\'s blood pressure was a bit high today (138/88). I\'ve noted it in the report.', 'created_at' => now()->subHours(5)]);
        Message::create(['conversation_id' => $conv->id, 'sender_id' => $users['caregiver_0']->id, 'content' => 'Thank you for letting me know. Should I be worried?', 'created_at' => now()->subHours(4)]);
        Message::create(['conversation_id' => $conv->id, 'sender_id' => $users['provider_0']->id, 'content' => 'Not immediately, but we should monitor it. I\'ll check again on my next visit.', 'created_at' => now()->subHours(3)]);

        // Conversation between caregiver 1 and provider 1 (physio)
        $conv2 = Conversation::create([
            'subject' => 'Henri\'s physio progress',
            'type' => 'direct',
            'beneficiary_id' => $beneficiaries[1]->id,
            'participants' => json_encode([$users['caregiver_1']->id, $users['provider_1']->id]),
            'last_message_at' => now()->subDays(1),
        ]);

        Message::create(['conversation_id' => $conv2->id, 'sender_id' => $users['provider_1']->id, 'content' => 'Henri is making good progress with his walking exercises. Balance is improving.', 'created_at' => now()->subDays(1)]);
        Message::create(['conversation_id' => $conv2->id, 'sender_id' => $users['caregiver_1']->id, 'content' => 'That\'s great to hear! How often should he do the home exercises?', 'created_at' => now()->subDays(1)->addMinutes(30)]);
    }

    private function seedAlerts($beneficiaries, $interventions, $users)
    {
        $alerts = [
            [$beneficiaries[0]->id, 'missed_visit', 'warning', 'Missed Visit', 'Nurse visit scheduled for 10:00 was missed. Provider did not arrive.', $interventions[5]->id ?? null, $users['caregiver_0']->id],
            [$beneficiaries[0]->id, 'service_completed', 'info', 'Service Completed', 'Home care visit completed. Proof of service available.', null, $users['beneficiary_0']->id],
            [$beneficiaries[1]->id, 'provider_note_attention', 'warning', 'Attention Required', 'Physiotherapist noted increased tremor in right hand.', null, $users['caregiver_1']->id],
            [$beneficiaries[2]->id, 'unusual_inactivity', 'critical', 'Unusual Inactivity', 'No activity recorded for 2 days. Please check on Suzanne.', null, $users['caregiver_2']->id],
            [$beneficiaries[0]->id, 'appointment_reminder', 'info', 'Appointment Reminder', 'Doctor visit scheduled for tomorrow at 14:00.', null, $users['beneficiary_0']->id],
        ];

        foreach ($alerts as $a) {
            Alert::create([
                'beneficiary_id' => $a[0],
                'intervention_id' => $a[5],
                'type' => $a[1],
                'severity' => $a[2],
                'title' => $a[3],
                'description' => $a[4],
                'target_user_id' => $a[6],
                'is_read' => false,
            ]);
        }
    }

    private function seedReminders($beneficiaries, $users)
    {
        Reminder::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['beneficiary_0']->id, 'title' => 'Take medication', 'type' => 'medication', 'remind_at' => now()->addHours(2), 'frequency' => 'daily', 'is_active' => true]);
        Reminder::create(['beneficiary_id' => $beneficiaries[0]->id, 'user_id' => $users['beneficiary_0']->id, 'title' => 'Doctor appointment', 'type' => 'appointment', 'remind_at' => now()->addDays(1), 'frequency' => 'once', 'is_active' => true]);
        Reminder::create(['beneficiary_id' => $beneficiaries[1]->id, 'user_id' => $users['beneficiary_1']->id, 'title' => 'Morning exercises', 'type' => 'activity', 'remind_at' => now()->addHours(1), 'frequency' => 'daily', 'is_active' => true]);
        Reminder::create(['beneficiary_id' => $beneficiaries[2]->id, 'user_id' => $users['beneficiary_2']->id, 'title' => 'Lunch time', 'type' => 'meal', 'remind_at' => now()->addMinutes(30), 'frequency' => 'daily', 'is_active' => true]);
    }

    private function seedDocuments($beneficiaries, $users)
    {
        Document::create(['beneficiary_id' => $beneficiaries[0]->id, 'uploaded_by' => $users['provider_3']->id, 'name' => 'Hip Surgery Report', 'file_path' => 'documents/hip_surgery.pdf', 'file_type' => 'application/pdf', 'category' => 'care_plan']);
        Document::create(['beneficiary_id' => $beneficiaries[0]->id, 'uploaded_by' => $users['provider_0']->id, 'name' => 'Medication List', 'file_path' => 'documents/meds.pdf', 'file_type' => 'application/pdf', 'category' => 'prescription']);
        Document::create(['beneficiary_id' => $beneficiaries[1]->id, 'uploaded_by' => $users['provider_1']->id, 'name' => 'Physio Assessment', 'file_path' => 'documents/physio.pdf', 'file_type' => 'application/pdf', 'category' => 'assessment']);
    }

    private function seedServiceRequests($beneficiaries, $users, $categories)
    {
        ServiceRequest::create(['beneficiary_id' => $beneficiaries[0]->id, 'requested_by' => $users['caregiver_0']->id, 'service_category_id' => $categories['meals'] ?? null, 'title' => 'Meal preparation service needed', 'urgency' => 'normal', 'status' => 'open', 'funding_preference' => 'any', 'description' => 'Looking for someone to prepare lunch 3 times a week.']);
        ServiceRequest::create(['beneficiary_id' => $beneficiaries[1]->id, 'requested_by' => $users['caregiver_1']->id, 'service_category_id' => $categories['transportation'] ?? null, 'title' => 'Transport to neurologist appointment', 'urgency' => 'high', 'status' => 'matching', 'funding_preference' => 'state_funded', 'description' => 'Need transport for Henri to see his neurologist next week.']);
        ServiceRequest::create(['beneficiary_id' => $beneficiaries[2]->id, 'requested_by' => $users['caregiver_2']->id, 'service_category_id' => $categories['accompaniment'] ?? null, 'title' => 'Social activity companion', 'urgency' => 'low', 'status' => 'open', 'funding_preference' => 'any', 'description' => 'Looking for someone to accompany Suzanne on weekly walks.']);
    }

    private function seedCrossProfessionalRequests($beneficiaries, $providers)
    {
        CrossProfessionalRequest::create(['beneficiary_id' => $beneficiaries[0]->id, 'from_provider_id' => $providers[0]->id, 'to_provider_id' => $providers[3]->id, 'title' => 'Prescription renewal needed', 'type' => 'prescription_renewal', 'status' => 'pending', 'description' => 'Marie needs her hypertension medication prescription renewed.']);
        CrossProfessionalRequest::create(['beneficiary_id' => $beneficiaries[1]->id, 'from_provider_id' => $providers[1]->id, 'to_provider_id' => $providers[0]->id, 'title' => 'BP monitoring during physio', 'type' => 'bp_monitoring', 'status' => 'accepted', 'description' => 'Please monitor Henri\'s BP during your visits as he\'s on new Parkinson medication.']);
    }

    private function seedComplaints($beneficiaries, $users)
    {
        Complaint::create(['beneficiary_id' => $beneficiaries[0]->id, 'filed_by' => $users['caregiver_0']->id, 'intervention_id' => 1, 'subject' => 'Missed visit not communicated', 'description' => 'The nurse did not show up for the scheduled visit and no one informed us. We waited 2 hours.', 'severity' => 'high', 'status' => 'open', 'assigned_admin_id' => $users['admin']->id]);
        Complaint::create(['beneficiary_id' => $beneficiaries[2]->id, 'filed_by' => $users['caregiver_2']->id, 'subject' => 'Late arrival', 'description' => 'Home care assistant arrived 45 minutes late without prior notice.', 'severity' => 'medium', 'status' => 'resolved', 'resolution_notes' => 'Spoke with provider. Apology issued. Will call ahead next time.', 'resolved_at' => now()->subDays(3)]);
    }

    private function seedProviderAvailability($providers)
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($providers as $provider) {
            if ($provider->verification_status !== 'approved') continue;
            foreach ($days as $day) {
                $start = $day === 'saturday' || $day === 'sunday' ? '09:00' : '08:00';
                $end = $day === 'saturday' || $day === 'sunday' ? '13:00' : '18:00';
                ProviderAvailability::create([
                    'provider_id' => $provider->id,
                    'day_of_week' => $day,
                    'start_time' => $start,
                    'end_time' => $end,
                    'is_available' => !($day === 'sunday'),
                ]);
            }
        }
    }

    private function seedProviderReviews($providers, $users, $interventions)
    {
        $reviews = [
            [0, 5, 'Excellent care, very professional and kind.'],
            [0, 5, 'Marie loves her visits. Very patient and thorough.'],
            [1, 4, 'Good physio sessions, Henri is improving.'],
            [1, 5, 'Very knowledgeable and gentle approach.'],
            [2, 4, 'Reliable and punctual. Good cleaning service.'],
            [2, 5, 'Very caring and attentive.'],
            [3, 5, 'Excellent doctor, very thorough home visits.'],
        ];

        foreach ($reviews as $i => $r) {
            $provIdx = $r[0];
            if (!isset($providers[$provIdx])) continue;
            ProviderReview::create([
                'provider_id' => $providers[$provIdx]->id,
                'reviewer_id' => $users['caregiver_' . ($provIdx % 3)]->id,
                'intervention_id' => $interventions[$i % count($interventions)]->id,
                'rating' => $r[1],
                'comment' => $r[2],
            ]);
        }
    }

    private function seedSubscriptions($users)
    {
        Subscription::create(['user_id' => $users['caregiver_0']->id, 'plan' => 'premium', 'billing_cycle' => 'monthly', 'amount' => 19.90, 'status' => 'active', 'started_at' => now()->subMonths(2), 'care_circle_limit' => 10, 'features' => json_encode(['all_features', 'unlimited_circle'])]);
        Subscription::create(['user_id' => $users['caregiver_1']->id, 'plan' => 'essential', 'billing_cycle' => 'monthly', 'amount' => 9.90, 'status' => 'active', 'started_at' => now()->subMonth(), 'care_circle_limit' => 3, 'features' => json_encode(['basic_coordination'])]);
        Subscription::create(['user_id' => $users['provider_0']->id, 'plan' => 'professional', 'billing_cycle' => 'monthly', 'amount' => 20.00, 'status' => 'active', 'started_at' => now()->subMonths(3), 'features' => json_encode(['full_provider_access'])]);
    }

    private function seedConsentLogs($users)
    {
        foreach ($users as $key => $user) {
            ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'terms_of_service', 'granted' => true, 'description' => 'Accepted Terms of Service', 'version' => '1.0']);
            ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'privacy_policy', 'granted' => true, 'description' => 'Accepted Privacy Policy', 'version' => '1.0']);
        }
    }

    private function seedAuditLogs($users)
    {
        AuditLog::create(['user_id' => $users['admin']->id, 'action' => 'user_approved', 'model_type' => 'User', 'model_id' => $users['provider_0']->id, 'created_at' => now()->subDays(30)]);
        AuditLog::create(['user_id' => $users['admin']->id, 'action' => 'provider_verified', 'model_type' => 'Provider', 'model_id' => 1, 'created_at' => now()->subDays(25)]);
        AuditLog::create(['user_id' => $users['caregiver_0']->id, 'action' => 'service_requested', 'model_type' => 'ServiceRequest', 'created_at' => now()->subDays(5)]);
        AuditLog::create(['user_id' => $users['provider_0']->id, 'action' => 'visit_completed', 'model_type' => 'Intervention', 'created_at' => now()->subDays(1)]);
    }
}