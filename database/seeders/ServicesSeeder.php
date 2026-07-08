<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $providers = Provider::all()->keyBy(fn($p) => $p->profession);

        // Nurse services
        $nurse = $providers->get('nurse');
        $nurseCats = ServiceCategory::where('profession', 'nurse')->get()->keyBy('name');
        $nurseServices = [
            ['category' => 'Soins infirmiers sur prescription', 'title' => 'Injection d\'insuline matin et soir', 'duration' => 20, 'price' => 18, 'reimb' => 18, 'funding' => 'state_funded'],
            ['category' => 'Pansements et plaies', 'title' => 'Pansement ulcère veineux + surveillance', 'duration' => 45, 'price' => 25, 'reimb' => 20, 'funding' => 'partially_reimbursed'],
            ['category' => 'Surveillance des constantes', 'title' => 'Contrôle tension et glycémie hebdomadaire', 'duration' => 30, 'price' => 15, 'reimb' => 15, 'funding' => 'state_funded'],
            ['category' => 'Préparation et distribution de médicaments', 'title' => 'Préparation pilulier hebdomadaire', 'duration' => 30, 'price' => 12, 'reimb' => 12, 'funding' => 'state_funded'],
            ['category' => 'Soins post-opératoires', 'title' => 'Pansement post-chirurgical et surveillance', 'duration' => 40, 'price' => 22, 'reimb' => 22, 'funding' => 'state_funded'],
            ['category' => 'Éducation thérapeutique et autonomie', 'title' => 'Formation à l\'auto-injection d\'insuline', 'duration' => 60, 'price' => 30, 'reimb' => 30, 'funding' => 'state_funded'],
        ];

        // Physiotherapist services
        $physio = $providers->get('physiotherapist');
        $physioCats = ServiceCategory::where('profession', 'physiotherapist')->get()->keyBy('name');
        $physioServices = [
            ['category' => 'Rééducation motrice et marches', 'title' => 'Rééducation de la marche après hospitalisation', 'duration' => 45, 'price' => 35, 'reimb' => 21, 'funding' => 'partially_reimbursed'],
            ['category' => 'Massages et soulagement des douleurs', 'title' => 'Massage thérapeutique dos et cervicales', 'duration' => 30, 'price' => 30, 'reimb' => 18, 'funding' => 'partially_reimbursed'],
            ['category' => 'Renforcement musculaire et prévention chutes', 'title' => 'Programme Otago - prévention des chutes', 'duration' => 60, 'price' => 40, 'reimb' => 24, 'funding' => 'partially_reimbursed'],
            ['category' => 'Mobilité et transferts au domicile', 'title' => 'Séance de mobilité et transferts sécurisés', 'duration' => 45, 'price' => 35, 'reimb' => 21, 'funding' => 'partially_reimbursed'],
        ];

        // Home care assistant services
        $hca = $providers->get('home_care_assistant');
        $hcaCats = ServiceCategory::where('profession', 'home_care_assistant')->get()->keyBy('name');
        $hcaServices = [
            ['category' => 'Aide à la toilette et habillage', 'title' => 'Aide à la toilette et à l\'habillage du matin', 'duration' => 60, 'price' => 22, 'reimb' => 10, 'funding' => 'mixed', 'checklist' => ['Vérifier température eau', 'Respecter intimité', 'Vérifier peau']],
            ['category' => 'Aide aux repas et préparation', 'title' => 'Préparation du repas de midi et aide au repas', 'duration' => 90, 'price' => 28, 'reimb' => 12, 'funding' => 'mixed', 'checklist' => ['Vérifier régime alimentaire', 'Préparer repas équilibré', 'Surveiller hydratation']],
            ['category' => 'Aide au lever et au coucher', 'title' => 'Aide au lever et installation matinale', 'duration' => 45, 'price' => 18, 'reimb' => 8, 'funding' => 'mixed', 'checklist' => ['Vérifier environnement sécurisé', 'Aide au transfert', 'Vérifier confort']],
            ['category' => 'Aide à la mobilité et transferts', 'title' => 'Aide aux transferts et déplacements intérieurs', 'duration' => 30, 'price' => 15, 'reimb' => 7, 'funding' => 'mixed'],
            ['category' => 'Entretien du logement', 'title' => 'Entretien ménager hebdomadaire (2h)', 'duration' => 120, 'price' => 35, 'reimb' => 15, 'funding' => 'mixed', 'checklist' => ['Aspiration et serpillière', 'Désinfection surfaces', 'Rangement espaces de vie']],
            ['category' => 'Aide aux courses et approvisionnement', 'title' => 'Aide aux courses et préparation des repas de la semaine', 'duration' => 120, 'price' => 30, 'reimb' => 0, 'funding' => 'beneficiary_paid'],
            ['category' => 'Stimulation cognitive et loisirs', 'title' => 'Atelier mémoire et jeux de société', 'duration' => 60, 'price' => 20, 'reimb' => 0, 'funding' => 'beneficiary_paid'],
            ['category' => 'Promenade et activités extérieures', 'title' => 'Promenade au parc et activité physique adaptée', 'duration' => 60, 'price' => 20, 'reimb' => 0, 'funding' => 'beneficiary_paid'],
        ];

        // Physician services
        $physician = $providers->get('physician');
        $physicianCats = ServiceCategory::where('profession', 'physician')->get()->keyBy('name');
        $physicianServices = [
            ['category' => 'Consultation médicale à domicile', 'title' => 'Consultation médicale générale à domicile', 'duration' => 30, 'price' => 50, 'reimb' => 47, 'funding' => 'state_funded'],
            ['category' => 'Bilan de santé gériatrique', 'title' => 'Bilan gériatrique complet à domicile (MMSE, IADL, nutrition)', 'duration' => 90, 'price' => 80, 'reimb' => 75, 'funding' => 'state_funded'],
            ['category' => 'Gestion des traitements chroniques', 'title' => 'Suivi mensuel diabète type 2 et hypertension', 'duration' => 30, 'price' => 50, 'reimb' => 47, 'funding' => 'state_funded'],
            ['category' => 'Téléconsultation médicale', 'title' => 'Téléconsultation de suivi - pathologie chronique', 'duration' => 20, 'price' => 40, 'reimb' => 37, 'funding' => 'state_funded'],
            ['category' => 'Renouvellement d\'ordonnances', 'title' => 'Renouvellement d\'ordonnances médicales', 'duration' => 15, 'price' => 30, 'reimb' => 28, 'funding' => 'state_funded'],
            ['category' => 'Coordination avec spécialistes', 'title' => 'Coordination de parcours - avis cardiologique', 'duration' => 30, 'price' => 50, 'reimb' => 47, 'funding' => 'state_funded'],
            ['category' => 'Certificats médicaux et attestations', 'title' => 'Certificat médical pour APA', 'duration' => 20, 'price' => 30, 'reimb' => 0, 'funding' => 'beneficiary_paid'],
        ];

        // Social worker services
        $social = $providers->get('social_worker');
        $socialCats = ServiceCategory::where('profession', 'social_worker')->get()->keyBy('name');
        $socialServices = [
            ['category' => 'Évaluation sociale et médicosociale', 'title' => 'Évaluation sociale complète à domicile', 'duration' => 90, 'price' => 0, 'reimb' => 0, 'funding' => 'state_funded'],
            ['category' => 'Aide aux démarches administratives', 'title' => 'Accompagnement dossier APA et aide sociale', 'duration' => 60, 'price' => 0, 'reimb' => 0, 'funding' => 'state_funded'],
            ['category' => 'Coordination de parcours et orientations', 'title' => 'Coordination de parcours et plan d\'aide personnalisé', 'duration' => 60, 'price' => 0, 'reimb' => 0, 'funding' => 'state_funded'],
            ['category' => 'Accompagnement social et soutien psychosocial', 'title' => 'Soutien psychosocial - prévention de l\'isolement', 'duration' => 45, 'price' => 0, 'reimb' => 0, 'funding' => 'state_funded'],
        ];

        // Helper to create services
        $createServices = function($provider, $cats, $services) {
            foreach ($services as $s) {
                $category = $cats->get($s['category']);
                if (!$category) continue;
                Service::create([
                    'provider_id' => $provider->id,
                    'service_category_id' => $category->id,
                    'title' => $s['title'],
                    'description' => $s['title'] . '. Service réalisé par ' . $provider->user->full_name . '.',
                    'funding_type' => $s['funding'],
                    'base_price' => $s['price'],
                    'reimbursement_amount' => $s['reimb'],
                    'beneficiary_remainder' => $s['price'] - $s['reimb'],
                    'duration_minutes' => $s['duration'],
                    'funding_notes' => $s['funding'] === 'state_funded' ? 'Pris en charge par l\'Assurance Maladie' : ($s['funding'] === 'partially_reimbursed' ? 'Remboursement partiel CPAM, reste à charge pour le bénéficiaire ou la mutuelle' : 'Service à charge du bénéficiaire ou de la caisse de retraite'),
                    'checklist_template' => $s['checklist'] ?? null,
                    'notes_template' => ['Arrivée et accueil', 'Réalisation du service', 'Vérification du bien-être', 'Notes et observations'],
                    'required_documents' => $s['funding'] === 'state_funded' ? ['Ordonnance médicale'] : [],
                    'is_predefined' => false,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        };

        $createServices($nurse, $nurseCats, $nurseServices);
        $createServices($physio, $physioCats, $physioServices);
        $createServices($hca, $hcaCats, $hcaServices);
        $createServices($physician, $physicianCats, $physicianServices);
        $createServices($social, $socialCats, $socialServices);
    }
}