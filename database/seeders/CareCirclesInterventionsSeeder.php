<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\CareCircle;
use App\Models\Intervention;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use App\Models\VisitReport;
use Illuminate\Database\Seeder;

class CareCirclesInterventionsSeeder extends Seeder
{
    public function run(): void
    {
        $beneficiaries = Beneficiary::all();
        $providers = Provider::all();
        $caregivers = User::whereHas('role', fn($q) => $q->where('name', 'caregiver'))->get();

        // === Care Circles ===
        foreach ($beneficiaries as $index => $beneficiary) {
            // Link caregiver to beneficiary
            $caregiver = $caregivers[$index] ?? $caregivers[0];
            CareCircle::create([
                'beneficiary_id' => $beneficiary->id,
                'user_id' => $caregiver->id,
                'member_type' => 'caregiver',
                'relationship' => $index === 2 ? 'child' : ($index === 0 ? 'child' : 'child'),
                'permissions' => ['view_only' => false, 'message_providers' => true, 'manage_schedule' => true, 'approve_services' => true, 'receive_alerts' => true],
                'status' => 'active',
                'invited_at' => now()->subDays(60),
                'accepted_at' => now()->subDays(58),
            ]);

            // Link providers to beneficiaries via care circle
            foreach ($providers as $pIndex => $provider) {
                if ($pIndex >= 3) break; // first 3 providers per beneficiary
                CareCircle::create([
                    'beneficiary_id' => $beneficiary->id,
                    'user_id' => $provider->user_id,
                    'member_type' => 'provider',
                    'relationship' => 'other',
                    'permissions' => ['view_only' => false, 'message_providers' => true, 'manage_schedule' => false, 'approve_services' => false, 'receive_alerts' => true],
                    'status' => 'active',
                    'invited_at' => now()->subDays(50),
                    'accepted_at' => now()->subDays(48),
                ]);
            }
        }

        // === Interventions ===
        $nurse = Provider::where('profession', 'nurse')->first();
        $physio = Provider::where('profession', 'physiotherapist')->first();
        $hca = Provider::where('profession', 'home_care_assistant')->first();
        $physician = Provider::where('profession', 'physician')->first();
        $social = Provider::where('profession', 'social_worker')->first();

        $interventions = [
            // Marguerite Dubois (beneficiary 0)
            ['beneficiary' => 0, 'provider' => $nurse, 'service' => 'Injection d\'insuline matin et soir', 'title' => 'Injection d\'insuline - matin', 'scheduled' => now()->subDays(2)->setTime(8, 0), 'duration' => 20, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(2)->setTime(8, 20)],
            ['beneficiary' => 0, 'provider' => $nurse, 'service' => 'Injection d\'insuline matin et soir', 'title' => 'Injection d\'insuline - matin', 'scheduled' => now()->subDays(1)->setTime(8, 0), 'duration' => 20, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(1)->setTime(8, 18)],
            ['beneficiary' => 0, 'provider' => $nurse, 'service' => 'Injection d\'insuline matin et soir', 'title' => 'Injection d\'insuline - matin', 'scheduled' => now()->addDay()->setTime(8, 0), 'duration' => 20, 'status' => 'scheduled', 'mode' => 'home_visit'],
            ['beneficiary' => 0, 'provider' => $nurse, 'service' => 'Contrôle tension et glycémie hebdomadaire', 'title' => 'Contrôle tension et glycémie', 'scheduled' => now()->subDays(7)->setTime(10, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(7)->setTime(10, 28)],
            ['beneficiary' => 0, 'provider' => $hca, 'service' => 'Aide à la toilette et à l\'habillage du matin', 'title' => 'Aide à la toilette matinale', 'scheduled' => now()->subDays(3)->setTime(9, 0), 'duration' => 60, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(3)->setTime(9, 55)],
            ['beneficiary' => 0, 'provider' => $hca, 'service' => 'Préparation du repas de midi et aide au repas', 'title' => 'Préparation et aide au repas', 'scheduled' => now()->subDays(3)->setTime(11, 0), 'duration' => 90, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(3)->setTime(12, 25)],
            ['beneficiary' => 0, 'provider' => $hca, 'service' => 'Entretien ménager hebdomadaire (2h)', 'title' => 'Entretien ménager hebdomadaire', 'scheduled' => now()->subDays(5)->setTime(14, 0), 'duration' => 120, 'status' => 'missed', 'mode' => 'home_visit', 'notes' => 'Bénéficiaire absente - rendez-vous manqué'],
            ['beneficiary' => 0, 'provider' => $physician, 'service' => 'Consultation médicale générale à domicile', 'title' => 'Consultation médicale de suivi', 'scheduled' => now()->subDays(10)->setTime(15, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(10)->setTime(15, 25)],
            ['beneficiary' => 0, 'provider' => $physician, 'service' => 'Renouvellement d\'ordonnances médicales', 'title' => 'Renouvellement ordonnances', 'scheduled' => now()->subDays(10)->setTime(15, 30), 'duration' => 15, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(10)->setTime(15, 40)],
            ['beneficiary' => 0, 'provider' => $hca, 'service' => 'Promenade au parc et activité physique adaptée', 'title' => 'Promenade au parc', 'scheduled' => now()->addDays(3)->setTime(10, 0), 'duration' => 60, 'status' => 'scheduled', 'mode' => 'home_visit'],

            // Henri Lambert (beneficiary 1)
            ['beneficiary' => 1, 'provider' => $nurse, 'service' => 'Pansement ulcère veineux + surveillance', 'title' => 'Pansement ulcère veineux', 'scheduled' => now()->subDays(4)->setTime(9, 0), 'duration' => 45, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(4)->setTime(9, 40)],
            ['beneficiary' => 1, 'provider' => $nurse, 'service' => 'Préparation pilulier hebdomadaire', 'title' => 'Préparation pilulier', 'scheduled' => now()->subDays(6)->setTime(10, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(6)->setTime(10, 25)],
            ['beneficiary' => 1, 'provider' => $physio, 'service' => 'Rééducation de la marche après hospitalisation', 'title' => 'Rééducation de la marche', 'scheduled' => now()->subDays(2)->setTime(11, 0), 'duration' => 45, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(2)->setTime(11, 38)],
            ['beneficiary' => 1, 'provider' => $physio, 'service' => 'Massage thérapeutique dos et cervicales', 'title' => 'Massage thérapeutique', 'scheduled' => now()->subDays(4)->setTime(14, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(4)->setTime(14, 28)],
            ['beneficiary' => 1, 'provider' => $physio, 'service' => 'Programme Otago - prévention des chutes', 'title' => 'Programme Otago - séance 1', 'scheduled' => now()->addDays(2)->setTime(11, 0), 'duration' => 60, 'status' => 'scheduled', 'mode' => 'home_visit'],
            ['beneficiary' => 1, 'provider' => $hca, 'service' => 'Aide aux courses et préparation des repas de la semaine', 'title' => 'Aide aux courses de la semaine', 'scheduled' => now()->subDays(5)->setTime(9, 30), 'duration' => 120, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(5)->setTime(11, 15)],
            ['beneficiary' => 1, 'provider' => $physician, 'service' => 'Suivi mensuel diabète type 2 et hypertension', 'title' => 'Suivi mensuel diabète + HTA', 'scheduled' => now()->subDays(14)->setTime(16, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(14)->setTime(16, 28)],

            // Simone Roux (beneficiary 2)
            ['beneficiary' => 2, 'provider' => $hca, 'service' => 'Aide à la toilette et à l\'habillage du matin', 'title' => 'Aide à la toilette matinale', 'scheduled' => now()->subDays(1)->setTime(8, 30), 'duration' => 60, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(1)->setTime(9, 25)],
            ['beneficiary' => 2, 'provider' => $hca, 'service' => 'Aide au lever et installation matinale', 'title' => 'Aide au lever', 'scheduled' => now()->subDays(1)->setTime(7, 30), 'duration' => 45, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(1)->setTime(8, 10)],
            ['beneficiary' => 2, 'provider' => $nurse, 'service' => 'Contrôle tension et glycémie hebdomadaire', 'title' => 'Contrôle des constantes', 'scheduled' => now()->subDays(3)->setTime(9, 0), 'duration' => 30, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(3)->setTime(9, 25)],
            ['beneficiary' => 2, 'provider' => $physician, 'service' => 'Bilan gériatrique complet à domicile (MMSE, IADL, nutrition)', 'title' => 'Bilan gériatrique complet', 'scheduled' => now()->subDays(20)->setTime(10, 0), 'duration' => 90, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(20)->setTime(11, 30)],
            ['beneficiary' => 2, 'provider' => $physician, 'service' => 'Téléconsultation de suivi - pathologie chronique', 'title' => 'Téléconsultation de suivi', 'scheduled' => now()->subDays(5)->setTime(17, 0), 'duration' => 20, 'status' => 'cancelled', 'mode' => 'tele_support', 'notes' => 'Annulée - bénéficiaire fatiguée', 'cancel_reason' => 'Bénéficiaire indisposée'],
            ['beneficiary' => 2, 'provider' => $social, 'service' => 'Évaluation sociale complète à domicile', 'title' => 'Évaluation sociale à domicile', 'scheduled' => now()->subDays(12)->setTime(10, 0), 'duration' => 90, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(12)->setTime(11, 40)],
            ['beneficiary' => 2, 'provider' => $social, 'service' => 'Accompagnement dossier APA et aide sociale', 'title' => 'Accompagnement dossier APA', 'scheduled' => now()->subDays(12)->setTime(11, 0), 'duration' => 60, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(12)->setTime(12, 10)],
            ['beneficiary' => 2, 'provider' => $social, 'service' => 'Soutien psychosocial - prévention de l\'isolement', 'title' => 'Soutien psychosocial hebdomadaire', 'scheduled' => now()->addDays(4)->setTime(14, 0), 'duration' => 45, 'status' => 'scheduled', 'mode' => 'home_visit'],
            ['beneficiary' => 2, 'provider' => $hca, 'service' => 'Atelier mémoire et jeux de société', 'title' => 'Atelier mémoire', 'scheduled' => now()->subDays(3)->setTime(15, 0), 'duration' => 60, 'status' => 'completed', 'mode' => 'home_visit', 'completed' => now()->subDays(3)->setTime(15, 55)],
            ['beneficiary' => 2, 'provider' => $nurse, 'service' => 'Injection d\'insuline matin et soir', 'title' => 'Injection d\'insuline - matin', 'scheduled' => now()->subDays(8)->setTime(8, 0), 'duration' => 20, 'status' => 'cancelled', 'mode' => 'home_visit', 'cancel_reason' => 'Provider indisponible - remplacement en cours', 'notes' => 'Intervention annulée, infirmière remplacée'],
            ['beneficiary' => 2, 'provider' => $physician, 'service' => 'Consultation médicale générale à domicile', 'title' => 'Consultation médicale', 'scheduled' => now()->subDays(1)->setTime(14, 0), 'duration' => 30, 'status' => 'in_progress', 'mode' => 'home_visit', 'started' => now()->subDay()->setTime(14, 0)],
        ];

        foreach ($interventions as $i) {
            $bIndex = $i['beneficiary'];
            $provider = $i['provider'];
            $serviceTitle = $i['service'] ?? null;
            $scheduled = $i['scheduled'];
            $duration = $i['duration'];
            $status = $i['status'];
            $mode = $i['mode'];
            $title = $i['title'];
            $completed = $i['completed'] ?? null;
            $started = $i['started'] ?? null;
            $cancelReason = $i['cancel_reason'] ?? null;
            $notes = $i['notes'] ?? null;

            $service = Service::where('title', $serviceTitle)->first();

            $interventionData = [
                'beneficiary_id' => $beneficiaries[$bIndex]->id,
                'provider_id' => $provider->id,
                'service_id' => $service?->id,
                'title' => $title,
                'scheduled_at' => $scheduled,
                'duration_minutes' => $duration,
                'status' => $status,
                'service_mode' => $mode,
                'address' => $beneficiaries[$bIndex]->address . ', ' . $beneficiaries[$bIndex]->city . ' ' . $beneficiaries[$bIndex]->postal_code,
            ];

            if ($completed) $interventionData['completed_at'] = $completed;
            if ($started) $interventionData['started_at'] = $started;
            if ($cancelReason) {
                $interventionData['cancelled_at'] = $scheduled;
                $interventionData['cancel_reason'] = $cancelReason;
            }
            if ($notes) $interventionData['notes'] = $notes;

            $interventionData['funding_info'] = $service ? [
                'funding_type' => $service->funding_type,
                'base_price' => $service->base_price,
                'reimbursement_amount' => $service->reimbursement_amount,
                'beneficiary_remainder' => $service->beneficiary_remainder,
            ] : null;

            $intervention = Intervention::create($interventionData);

            // Create visit reports for completed interventions
            if ($status === 'completed' && $completed) {
                $reportData = [
                    'intervention_id' => $intervention->id,
                    'provider_id' => $provider->id,
                    'checklist_completed' => ['Arrival and greeting' => true, 'Service provided' => true, 'Beneficiary wellbeing checked' => true, 'Notes recorded' => true],
                    'notes' => $this->getVisitNotes($i['title'], $bIndex),
                    'photos' => [],
                    'documents' => [],
                    'signature' => null,
                    'service_outcome' => 'fully_completed',
                    'recommended_next_action' => $bIndex === 2 ? 'Continuer le suivi rapproché - évaluer la nécessité d\'augmenter le niveau d\'aide' : 'Maintenir le rythme des visites. RAS particulier.',
                    'mood' => ['good', 'neutral', 'low'][$bIndex] ?? 'neutral',
                    'appetite' => ['good', 'medium', 'low'][$bIndex] ?? 'medium',
                    'mobility' => ['good', 'limited', 'assisted'][$bIndex] ?? 'limited',
                    'engagement' => ['active', 'responsive', 'passive'][$bIndex] ?? 'responsive',
                    'hydration' => ['good', 'adequate', 'low'][$bIndex] ?? 'adequate',
                    'is_family_summary_generated' => $bIndex === 0,
                    'family_summary' => $bIndex === 0 ? 'Marguerite va bien aujourd\'hui. La toilette et le repas se sont bien déroulés. Humeur joyeuse, a discuté de ses lectures. Tension stable à 128/78. L\'injection d\'insuline a été faite sans difficulté.' : null,
                ];

                // Add vital signs for nurse/physician interventions
                if (in_array($provider->profession, ['nurse', 'physician'])) {
                    $reportData['blood_pressure_systolic'] = [128, 135, 142][$bIndex] ?? 130;
                    $reportData['blood_pressure_diastolic'] = [78, 85, 90][$bIndex] ?? 82;
                    $reportData['heart_rate'] = [72, 78, 84][$bIndex] ?? 75;
                    $reportData['temperature'] = 36.6 + $bIndex * 0.2;
                    $reportData['oxygen_saturation'] = [98, 96, 94][$bIndex] ?? 97;
                    if ($provider->profession === 'nurse') {
                        $reportData['blood_glucose'] = [110, 145, 130][$bIndex] ?? 120;
                    }
                    $reportData['pain_level'] = [0, 3, 2][$bIndex] ?? 1;
                    $reportData['weight'] = [58, 82, 52][$bIndex] ?? 65;
                }

                VisitReport::create($reportData);
            }
        }
    }

    private function getVisitNotes(string $title, int $bIndex): string
    {
        $names = ['Marguerite', 'Henri', 'Simone'];

        if (str_contains($title, 'Insuline')) {
            return "Glycémie capillaire avant injection : {$names[$bIndex]} coopérante. Injection réalisée sans difficulté. Site d'injection alterné. Aucun signe d'hypoglycémie.";
        }
        if (str_contains($title, 'Pansement')) {
            return "Pansement réalisé. Plaie propre, cicatrisation en bon progrès. Pas de signe d'infection. Changement de pansement tous les 2 jours recommandé.";
        }
        if (str_contains($title, 'Toilette')) {
            return "{$names[$bIndex]} a pu être accompagnée pour la toilette en toute autonomie partielle. Peau intacte, pas de rougeur. Habillage réalisé avec aide minimale.";
        }
        if (str_contains($title, 'Repas')) {
            return "Repas préparé et pris ensemble. {$names[$bIndex]} a mangé avec appétit. Hydratation assurée : 2 verres d'eau pendant le repas.";
        }
        if (str_contains($title, 'Rééducation')) {
            return "Séance de rééducation de 45 min. {$names[$bIndex]} a réalisé les exercices avec motivation. Amélioration de l'équilibre notée. À poursuivre 2x/semaine.";
        }
        if (str_contains($title, 'Massage')) {
            return "Massage de 30 min. Douleurs cervicales atténuées. {$names[$bIndex]} signale une amélioration. Recommandation : étirements quotidiens.";
        }
        if (str_contains($title, 'Consultation') || str_contains($title, 'Suivi')) {
            return "Examen clinique réalisé. État général stable. Pas de nouvelle plainte. Traitement maintenu. Prochain rendez-vous dans 1 mois.";
        }
        if (str_contains($title, 'Bilan')) {
            return "Bilan gériatrique complet. MMSE : 22/30 (démence débutante). IADL : 4/8. Nutrition : risque de dénutrition modéré. Recommandation : augmentation de l'aide à domicile.";
        }
        if (str_contains($title, 'Évaluation sociale') || str_contains($title, 'APA')) {
            return "Évaluation sociale complète. Situation financière précaire. Dossier APA en cours de constitution. Recommandation : aide à domicile quotidienne + portage de repas.";
        }
        if (str_contains($title, 'Atelier')) {
            return "{$names[$bIndex]} a participé activement à l'atelier mémoire. Bon engagement, plaisir visible. Exercices de mémoire et de logique réalisés avec succès.";
        }
        if (str_contains($title, 'Courses')) {
            return "Courses réalisées au supermarché du quartier. {$names[$bIndex]} a choisi ses produits. Repas de la semaine préparés et stockés. Bon appétit ce midi.";
        }
        if (str_contains($title, 'Lever')) {
            return "{$names[$bIndex]} s'est levée avec aide. Transfert lit-fauteuil sécurisé. Aucune douleur signalée. Installation confortable pour la journée.";
        }

        return "Visite réalisée dans de bonnes conditions. {$names[$bIndex]} était réceptif/ve. Aucun élément particulier à signaler.";
    }
}