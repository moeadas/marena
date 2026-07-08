<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Beneficiary;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Intervention;
use App\Models\Reminder;
use App\Models\Document;
use App\Models\ServiceRequest;
use App\Models\CrossProfessionalRequest;
use App\Models\Complaint;
use App\Models\ProviderReview;
use App\Models\Subscription;
use App\Models\ConsentLog;
use App\Models\AuditLog;
use App\Models\Provider;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MessagingAlertsRemindersSeeder extends Seeder
{
    public function run(): void
    {
        $beneficiaries = Beneficiary::all()->values();
        $caregivers = User::whereHas('role', fn($q) => $q->where('name', 'caregiver'))->get()->values();
        $providers = Provider::all()->values();
        $admin = User::where('email', 'admin@marena.fr')->first();

        // === Conversations & Messages ===
        // Conversation 1: Julie (caregiver) <-> Nurse Nadine about Marguerite
        $conv1 = Conversation::create([
            'subject' => 'Suivi Marguerite - insuline',
            'type' => 'direct',
            'beneficiary_id' => $beneficiaries[0]->id,
            'participants' => [$caregivers[0]->id, $providers[0]->user_id],
            'last_message_at' => now()->subDays(1),
        ]);
        $this->createMessages($conv1, [
            ['sender_id' => $caregivers[0]->id, 'content' => 'Bonjour, comment s\'est passée la visite de ce matin ? Maman était-elle coopérante ?', 'ago' => 3],
            ['sender_id' => $providers[0]->user_id, 'content' => 'Bonjour Julie, très bien! Marguerite était en forme. Glycémie à 1.10 g/L, injection faite sans souci.', 'ago' => 3],
            ['sender_id' => $caregivers[0]->id, 'content' => 'C\'est rassurant. Merci beaucoup pour votre suivi.', 'ago' => 1],
            ['sender_id' => $providers[0]->user_id, 'content' => 'De rien. Je serai là demain matin à 8h comme d\'habitude.', 'ago' => 1],
        ]);

        // Conversation 2: Pierre (caregiver) <-> Dr. Lefebvre about Henri
        $conv2 = Conversation::create([
            'subject' => 'Renouvellement ordonnance Henri',
            'type' => 'direct',
            'beneficiary_id' => $beneficiaries[1]->id,
            'participants' => [$caregivers[1]->id, $providers[3]->user_id],
            'last_message_at' => now()->subDays(5),
        ]);
        $this->createMessages($conv2, [
            ['sender_id' => $caregivers[1]->id, 'content' => 'Bonjour Docteur, papa a besoin d\'un renouvellement d\'ordonnance pour ses médicaments.', 'ago' => 7],
            ['sender_id' => $providers[3]->user_id, 'content' => 'Bonjour Pierre, je passerai jeudi après-midi pour la consultation et je renouvellerai l\'ordonnance.', 'ago' => 7],
            ['sender_id' => $caregivers[1]->id, 'content' => 'Parfait, je préviendrai papa. Merci.', 'ago' => 6],
            ['sender_id' => $providers[3]->user_id, 'content' => 'Ordonnance renouvelée. J\'ai ajouté un dosage adapté pour la tension. Pensez à surveiller sa TA régulièrement.', 'ago' => 5],
        ]);

        // Conversation 3: Group conversation about Simone
        $conv3 = Conversation::create([
            'subject' => 'Coordination soins Simone Roux',
            'type' => 'group',
            'beneficiary_id' => $beneficiaries[2]->id,
            'participants' => [$caregivers[2]->id, $providers[0]->user_id, $providers[3]->user_id, $providers[4]->user_id],
            'last_message_at' => now()->subDays(1),
        ]);
        $this->createMessages($conv3, [
            ['sender_id' => $caregivers[2]->id, 'content' => 'Bonjour à tous, mamie Simone a été un peu confuse ce matin. Je m\'inquiète.', 'ago' => 5],
            ['sender_id' => $providers[0]->user_id, 'content' => 'Merci Claire pour l\'info. Je la verrai demain pour les constantes, je vérifierai son état cognitif.', 'ago' => 5],
            ['sender_id' => $providers[3]->user_id, 'content' => 'Je note pour le suivi. Si ça empire, il faudra peut-être revoir le bilan gériatrique.', 'ago' => 4],
            ['sender_id' => $providers[4]->user_id, 'content' => 'Je peux passer en début de semaine pour une évaluation à domicile et discuter des solutions.', 'ago' => 3],
            ['sender_id' => $caregivers[2]->id, 'content' => 'Merci à tous pour votre réactivité. Ça me rassure de savoir qu\'on surveille de près.', 'ago' => 1],
        ]);

        // === Alerts ===
        $alertsData = [
            // Marguerite
            ['beneficiary' => 0, 'type' => 'service_completed', 'severity' => 'info', 'title' => 'Visite infirmière terminée', 'description' => 'L\'injection d\'insuline du matin a été réalisée avec succès. Glycémie à 1.10 g/L.', 'ago' => 1, 'target' => 'caregiver', 'ci' => 0],
            ['beneficiary' => 0, 'type' => 'missed_visit', 'severity' => 'warning', 'title' => 'Rendez-vous manqué - ménage', 'description' => 'L\'intervention d\'entretien ménager prévue hier n\'a pas eu lieu. Bénéficiaire absente.', 'ago' => 5, 'target' => 'caregiver', 'ci' => 0],
            ['beneficiary' => 0, 'type' => 'appointment_reminder', 'severity' => 'info', 'title' => 'Rappel : Promenade au parc', 'description' => 'Une promenade au parc est prévue dans 3 jours avec Sophie.', 'ago' => 0, 'target' => 'beneficiary', 'ci' => 0],

            // Henri
            ['beneficiary' => 1, 'type' => 'service_completed', 'severity' => 'info', 'title' => 'Pansement réalisé', 'description' => 'Le pansement de l\'ulcère veineux a été changé. Bonne cicatrisation.', 'ago' => 4, 'target' => 'caregiver', 'ci' => 1],
            ['beneficiary' => 1, 'type' => 'medication_reminder', 'severity' => 'warning', 'title' => 'Rappel : Pilulier à préparer', 'description' => 'Le pilulier de Henri doit être préparé cette semaine.', 'ago' => 0, 'target' => 'beneficiary', 'ci' => 1],
            ['beneficiary' => 1, 'type' => 'unusual_pattern', 'severity' => 'warning', 'title' => 'Glycémie élevée détectée', 'description' => 'La dernière glycémie de Henri était à 1.45 g/L. Surveiller l\'alimentation.', 'ago' => 6, 'target' => 'caregiver', 'ci' => 1],

            // Simone
            ['beneficiary' => 2, 'type' => 'provider_note_attention', 'severity' => 'critical', 'title' => 'Signes de confusion', 'description' => 'Simone a présenté des signes de confusion ce matin. Évaluation recommandée.', 'ago' => 5, 'target' => 'caregiver', 'ci' => 2],
            ['beneficiary' => 2, 'type' => 'unusual_inactivity', 'severity' => 'warning', 'title' => 'Inactivité inhabituelle', 'description' => 'Aucune sortie enregistrée pour Simone depuis 5 jours. Vérifier son bien-être.', 'ago' => 2, 'target' => 'caregiver', 'ci' => 2],
            ['beneficiary' => 2, 'type' => 'missed_visit', 'severity' => 'warning', 'title' => 'Téléconsultation annulée', 'description' => 'La téléconsultation avec le médecin a été annulée. Simone était fatiguée. À reprogrammer.', 'ago' => 5, 'target' => 'caregiver', 'ci' => 2],
            ['beneficiary' => 2, 'type' => 'verification_pending', 'severity' => 'info', 'title' => 'Dossier APA en cours', 'description' => 'Le dossier d\'APA pour Simone a été déposé. En attente de validation du Conseil départemental.', 'ago' => 12, 'target' => 'caregiver', 'ci' => 2],
        ];

        foreach ($alertsData as $a) {
            $targetUser = $a['target'] === 'caregiver' ? $caregivers[$a['ci']] : $beneficiaries[$a['ci']]->user;
            Alert::create([
                'beneficiary_id' => $beneficiaries[$a['ci']]->id,
                'intervention_id' => null,
                'type' => $a['type'],
                'severity' => $a['severity'],
                'title' => $a['title'],
                'description' => $a['description'],
                'metadata' => null,
                'is_read' => $a['ago'] > 3,
                'read_at' => $a['ago'] > 3 ? now()->subDays($a['ago'] - 2) : null,
                'target_user_id' => $targetUser->id,
                'created_at' => now()->subDays($a['ago']),
            ]);
        }

        // === Reminders ===
        $remindersData = [
            ['beneficiary' => 0, 'user' => $caregivers[0], 'title' => 'Rappel insuline matin', 'description' => 'Nadine passe à 8h pour l\'injection d\'insuline', 'type' => 'appointment', 'remind_at' => now()->addDay()->setTime(7, 30), 'frequency' => 'daily'],
            ['beneficiary' => 0, 'user' => $caregivers[0], 'title' => 'Rappel hydratation', 'description' => 'Penser à vérifier que Marguerite boit suffisamment', 'type' => 'meal', 'remind_at' => now()->addDays(2)->setTime(12, 0), 'frequency' => 'daily'],
            ['beneficiary' => 1, 'user' => $caregivers[1], 'title' => 'Renouvellement ordonnance', 'description' => 'Penser à prendre RDV avec le Dr Lefebvre pour renouvellement', 'type' => 'appointment', 'remind_at' => now()->addDays(3)->setTime(9, 0), 'frequency' => 'once'],
            ['beneficiary' => 1, 'user' => $caregivers[1], 'title' => 'Rappel pilulier', 'description' => 'Préparer le pilulier de la semaine', 'type' => 'medication', 'remind_at' => now()->addDays(1)->setTime(10, 0), 'frequency' => 'weekly'],
            ['beneficiary' => 2, 'user' => $caregivers[2], 'title' => 'Rappel visite infirmière', 'description' => 'Nadine passe demain pour le contrôle des constantes', 'type' => 'appointment', 'remind_at' => now()->addDay()->setTime(8, 0), 'frequency' => 'once'],
            ['beneficiary' => 2, 'user' => $caregivers[2], 'title' => 'Rappel activité cognitive', 'description' => 'Atelier mémoire avec Sophie cet après-midi', 'type' => 'activity', 'remind_at' => now()->addDays(3)->setTime(14, 0), 'frequency' => 'weekly'],
            ['beneficiary' => 2, 'user' => $caregivers[2], 'title' => 'Rappel suivi APA', 'description' => 'Vérifier l\'avancée du dossier APA de mamie', 'type' => 'general', 'remind_at' => now()->addDays(7)->setTime(10, 0), 'frequency' => 'weekly'],
        ];

        foreach ($remindersData as $r) {
            Reminder::create([
                'beneficiary_id' => $beneficiaries[$r['beneficiary']]->id,
                'user_id' => $r['user']->id,
                'title' => $r['title'],
                'description' => $r['description'],
                'type' => $r['type'],
                'remind_at' => $r['remind_at'],
                'frequency' => $r['frequency'],
                'is_active' => true,
            ]);
        }

        // === Documents ===
        $documentsData = [
            ['beneficiary' => 0, 'uploaded_by' => $providers[3]->user_id, 'name' => 'Ordonnance renouvellement', 'description' => 'Ordonnance renouvelée par Dr Lefebvre', 'category' => 'prescription', 'type' => 'application/pdf', 'ago' => 10],
            ['beneficiary' => 0, 'uploaded_by' => $caregivers[0], 'name' => 'Plan d\'aide APA', 'description' => 'Plan d\'aide personnalisé', 'category' => 'assessment', 'type' => 'application/pdf', 'ago' => 30],
            ['beneficiary' => 0, 'uploaded_by' => $caregivers[0], 'name' => 'Carte vitale', 'description' => 'Copie carte vitale MGEN', 'category' => 'insurance', 'type' => 'image/jpeg', 'ago' => 45],
            ['beneficiary' => 1, 'uploaded_by' => $providers[0]->user_id, 'name' => 'Rapport de soins infirmiers', 'description' => 'Bilan des soins de pansement', 'category' => 'care_plan', 'type' => 'application/pdf', 'ago' => 4],
            ['beneficiary' => 1, 'uploaded_by' => $providers[3]->user_id, 'name' => 'Ordonnance diabète', 'description' => 'Traitement diabète type 2', 'category' => 'prescription', 'type' => 'application/pdf', 'ago' => 14],
            ['beneficiary' => 1, 'uploaded_by' => $caregivers[1], 'name' => 'Contrat mutuelle Harmonie', 'description' => 'Contrat d\'assurance Harmonie Mutuelle', 'category' => 'insurance', 'type' => 'application/pdf', 'ago' => 60],
            ['beneficiary' => 2, 'uploaded_by' => $providers[3]->user_id, 'name' => 'Bilan gériatrique complet', 'description' => 'MMSE, IADL, évaluation nutritionnelle, risque de chute', 'category' => 'assessment', 'type' => 'application/pdf', 'ago' => 20],
            ['beneficiary' => 2, 'uploaded_by' => $providers[4]->user_id, 'name' => 'Évaluation sociale', 'description' => 'Rapport d\'évaluation sociale et médicosociale', 'category' => 'assessment', 'type' => 'application/pdf', 'ago' => 12],
            ['beneficiary' => 2, 'uploaded_by' => $caregivers[2], 'name' => 'Mandat de protection', 'description' => 'Mandat de représentation légale', 'category' => 'legal', 'type' => 'application/pdf', 'ago' => 90],
            ['beneficiary' => 2, 'uploaded_by' => $caregivers[2], 'name' => 'Facture Auxiliaire Pro', 'description' => 'Facture des services d\'aide à domicile', 'category' => 'invoice', 'type' => 'application/pdf', 'ago' => 15],
        ];

        foreach ($documentsData as $d) {
            Document::create([
                'beneficiary_id' => $beneficiaries[$d['beneficiary']]->id,
                'uploaded_by' => is_object($d['uploaded_by']) ? $d['uploaded_by']->id : $d['uploaded_by'],
                'name' => $d['name'],
                'description' => $d['description'],
                'file_path' => 'documents/' . \Illuminate\Support\Str::slug($d['name']) . '.pdf',
                'file_type' => $d['type'],
                'file_size' => rand(50000, 500000),
                'category' => $d['category'],
                'metadata' => null,
                'created_at' => now()->subDays($d['ago']),
            ]);
        }

        // === Service Requests ===
        $serviceRequests = [
            ['beneficiary' => 0, 'requested_by' => $caregivers[0], 'category' => 'Promenade et activités extérieures', 'title' => 'Recherche accompagnateur pour promenades', 'description' => 'Marguerite aime se promener au parc mais ne peut plus sortir seule. Cherchons quelqu\'un pour 2 promenades par semaine.', 'urgency' => 'normal', 'status' => 'assigned', 'matched' => 'home_care_assistant', 'funding' => 'private', 'budget' => 25],
            ['beneficiary' => 1, 'requested_by' => $caregivers[1], 'category' => 'Soins infirmiers sur prescription', 'title' => 'Besoin de soins infirmiers 3x/semaine', 'description' => 'Henri a besoin de pansements réguliers pour son ulcère veineux. 3 visites par semaine souhaitées.', 'urgency' => 'high', 'status' => 'accepted', 'matched' => 'nurse', 'funding' => 'state_funded', 'budget' => null],
            ['beneficiary' => 2, 'requested_by' => $caregivers[2], 'category' => 'Stimulation cognitive et loisirs', 'title' => 'Atelier mémoire à domicile 2x/semaine', 'description' => 'Simone présente une démence débutante. Cherchons un intervenant pour atelier mémoire et stimulation cognitive à domicile.', 'urgency' => 'normal', 'status' => 'matching', 'matched' => null, 'funding' => 'any', 'budget' => 30],
        ];

        foreach ($serviceRequests as $sr) {
            $category = ServiceCategory::where('name', $sr['category'])->first();
            $matchedProvider = $sr['matched'] ? Provider::where('profession', $sr['matched'])->first() : null;

            ServiceRequest::create([
                'beneficiary_id' => $beneficiaries[$sr['beneficiary']]->id,
                'requested_by' => $sr['requested_by']->id,
                'service_category_id' => $category?->id,
                'title' => $sr['title'],
                'description' => $sr['description'],
                'urgency' => $sr['urgency'],
                'status' => $sr['status'],
                'schedule_preference' => ['days' => ['monday', 'wednesday', 'friday'], 'time' => 'morning'],
                'location' => $beneficiaries[$sr['beneficiary']]->city,
                'funding_preference' => $sr['funding'],
                'budget_max' => $sr['budget'],
                'notes' => null,
                'matched_provider_id' => $matchedProvider?->id,
            ]);
        }

        // === Cross-Professional Requests ===
        $nurse = Provider::where('profession', 'nurse')->first();
        $physician = Provider::where('profession', 'physician')->first();
        $physio = Provider::where('profession', 'physiotherapist')->first();
        $social = Provider::where('profession', 'social_worker')->first();

        $crossRequests = [
            ['beneficiary' => 0, 'from' => $nurse, 'to' => $physician, 'title' => 'Avis médical - glycémie instable', 'description' => 'Marguerite présente des glycémies variables. Avis médical souhaité pour ajustement du traitement.', 'type' => 'bp_monitoring', 'status' => 'accepted', 'ago' => 7],
            ['beneficiary' => 0, 'from' => $physician, 'to' => $nurse, 'title' => 'Renouvellement prescription soins infirmiers', 'description' => 'Nouvelle ordonnance pour soins infirmiers 3x/semaine.', 'type' => 'prescription_renewal', 'status' => 'completed', 'ago' => 14],
            ['beneficiary' => 1, 'from' => $physician, 'to' => $physio, 'title' => 'Prescription kinésithérapie', 'description' => 'Henri présente une raideur articulaire. Prescription de 10 séances de rééducation.', 'type' => 'physiotherapy', 'status' => 'accepted', 'ago' => 8],
            ['beneficiary' => 2, 'from' => $physician, 'to' => $social, 'title' => 'Demande évaluation sociale', 'description' => 'Simone nécessite une évaluation sociale complète pour mise en place d\'un plan d\'aide.', 'type' => 'coordination', 'status' => 'completed', 'ago' => 20],
            ['beneficiary' => 2, 'from' => $nurse, 'to' => $physician, 'title' => 'Évaluation cognitive - confusion récente', 'description' => 'Simone présente des signes de confusion matinaux. Évaluation gériatrique recommandée.', 'type' => 'assessment', 'status' => 'pending', 'ago' => 3],
            ['beneficiary' => 2, 'from' => $social, 'to' => $physician, 'title' => 'Coordination dossier APA', 'description' => 'Besoin d\'un certificat médical pour compléter le dossier APA de Simone.', 'type' => 'prescription_renewal', 'status' => 'pending', 'ago' => 1],
        ];

        foreach ($crossRequests as $cr) {
            CrossProfessionalRequest::create([
                'beneficiary_id' => $beneficiaries[$cr['beneficiary']]->id,
                'from_provider_id' => $cr['from']->id,
                'to_provider_id' => $cr['to']->id,
                'title' => $cr['title'],
                'description' => $cr['description'],
                'type' => $cr['type'],
                'status' => $cr['status'],
                'metadata' => null,
                'responded_at' => in_array($cr['status'], ['accepted', 'completed']) ? now()->subDays($cr['ago'] - 1) : null,
                'created_at' => now()->subDays($cr['ago']),
            ]);
        }

        // === Complaints ===
        $complaints = [
            ['beneficiary' => 0, 'filed_by' => $caregivers[0], 'against' => null, 'subject' => 'Ménage non réalisé à deux reprises', 'description' => 'L\'intervenant n\'est pas venu pour le ménage à deux reprises sans prévenir. Il faut reprogrammer.', 'severity' => 'low', 'status' => 'resolved', 'ago' => 12],
            ['beneficiary' => 1, 'filed_by' => $caregivers[1], 'against' => $providers[0]->user_id, 'subject' => 'Retard important lors de la dernière visite', 'description' => 'L\'infirmière est arrivée avec 45 minutes de retard et n\'a pas prévenu. Papa attendait et s\'était inquiété.', 'severity' => 'medium', 'status' => 'under_investigation', 'ago' => 5],
            ['beneficiary' => 2, 'filed_by' => $caregivers[2], 'against' => null, 'subject' => 'Téléconsultation annulée sans proposition de remplacement', 'description' => 'La téléconsultation avec le médecin a été annulée et aucun remplacement n\'a été proposé pour mamie.', 'severity' => 'medium', 'status' => 'open', 'ago' => 4],
        ];

        foreach ($complaints as $c) {
            Complaint::create([
                'beneficiary_id' => $beneficiaries[$c['beneficiary']]->id,
                'filed_by' => $c['filed_by']->id,
                'against_user_id' => $c['against'] ?? null,
                'intervention_id' => null,
                'subject' => $c['subject'],
                'description' => $c['description'],
                'severity' => $c['severity'],
                'status' => $c['status'],
                'assigned_admin_id' => $c['status'] !== 'open' ? $admin->id : null,
                'resolution_notes' => $c['status'] === 'resolved' ? 'Contact avec l\'intervenant. Excuses présentées. Ménage reprogrammé. Aucun incident ultérieur.' : null,
                'resolved_at' => $c['status'] === 'resolved' ? now()->subDays(5) : null,
                'created_at' => now()->subDays($c['ago']),
            ]);
        }

        // === Provider Reviews ===
        $interventions = Intervention::where('status', 'completed')->get();
        $reviewed = [];
        $reviewCount = 0;
        foreach ($interventions as $intervention) {
            if ($reviewCount >= 10) break;
            $key = $intervention->provider_id . '_' . $intervention->beneficiary_id;
            if (isset($reviewed[$key])) continue;
            $reviewed[$key] = true;
            $reviewCount++;

            $beneficiary = $intervention->beneficiary;
            $rating = rand(4, 5);
            $comments = [
                'Très professionnel/le et à l\'écoute. Je recommande.',
                'Visite efficace et bienveillante. Merci.',
                'Ponctuel/le et soigneux/se. Très satisfaite.',
                'Excellent suivi, explique bien les choses.',
                'Très bien, mais un léger retard une fois.',
            ];

            ProviderReview::create([
                'provider_id' => $intervention->provider_id,
                'reviewer_id' => $beneficiary->user_id,
                'intervention_id' => $intervention->id,
                'rating' => $rating,
                'comment' => $comments[array_rand($comments)],
                'is_disputed' => false,
                'dispute_reason' => null,
            ]);
        }

        // === Subscriptions ===
        $subscriptions = [
            ['user' => $admin, 'plan' => 'institutional', 'cycle' => 'annual', 'amount' => 5000, 'status' => 'active', 'limit' => 999, 'features' => ['all_features', 'unlimited_care_circles', 'priority_support']],
            ['user' => User::where('email', 'marguerite.dubois@example.fr')->first(), 'plan' => 'essential', 'cycle' => 'monthly', 'amount' => 19.99, 'status' => 'active', 'limit' => 5, 'features' => ['care_circle_5', 'messaging', 'alerts', 'visit_reports']],
            ['user' => User::where('email', 'henri.lambert@example.fr')->first(), 'plan' => 'essential', 'cycle' => 'monthly', 'amount' => 19.99, 'status' => 'active', 'limit' => 5, 'features' => ['care_circle_5', 'messaging', 'alerts', 'visit_reports']],
            ['user' => User::where('email', 'simone.roux@example.fr')->first(), 'plan' => 'premium', 'cycle' => 'monthly', 'amount' => 34.99, 'status' => 'active', 'limit' => 15, 'features' => ['care_circle_15', 'messaging', 'alerts', 'visit_reports', 'family_summary', 'ai_recommendations']],
            ['user' => User::where('email', 'nadine.martin@soin-domicile.fr')->first(), 'plan' => 'professional', 'cycle' => 'monthly', 'amount' => 49.99, 'status' => 'active', 'limit' => 20, 'features' => ['unlimited_interventions', 'visit_reports', 'availability_management', 'multi_beneficiary']],
            ['user' => User::where('email', 'marc.durand@auxiliaire-pro.fr')->first(), 'plan' => 'structure_license', 'cycle' => 'annual', 'amount' => 1200, 'status' => 'active', 'limit' => 50, 'features' => ['multi_employee', 'team_management', 'billing', 'reporting']],
        ];

        foreach ($subscriptions as $s) {
            Subscription::create([
                'user_id' => $s['user']->id,
                'plan' => $s['plan'],
                'billing_cycle' => $s['cycle'],
                'amount' => $s['amount'],
                'currency' => 'EUR',
                'status' => $s['status'],
                'started_at' => now()->subDays(rand(30, 90)),
                'expires_at' => $s['cycle'] === 'annual' ? now()->addMonths(rand(6, 9)) : now()->addDays(rand(5, 20)),
                'care_circle_limit' => $s['limit'],
                'features' => $s['features'],
            ]);
        }

        // === Consent Logs ===
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'terms_of_service', 'granted' => true, 'description' => 'Acceptation des conditions générales d\'utilisation', 'version' => '1.0']);
            ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'privacy_policy', 'granted' => true, 'description' => 'Acceptation de la politique de confidentialité (RGPD)', 'version' => '1.0']);
            ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'health_data', 'granted' => true, 'description' => 'Consentement au traitement des données de santé', 'version' => '1.0']);
            if ($user->hasRole('beneficiary')) {
                ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'data_sharing', 'granted' => true, 'description' => 'Consentement au partage des données avec le cercle de soins', 'version' => '1.0']);
                ConsentLog::create(['user_id' => $user->id, 'consent_type' => 'marketing', 'granted' => false, 'description' => 'Refus de recevoir les communications marketing', 'version' => '1.0']);
            }
        }

        // === Audit Logs ===
        $auditActions = [
            ['user' => $admin, 'action' => 'user.login', 'model' => 'User', 'model_id' => null, 'ago' => 0],
            ['user' => $admin, 'action' => 'provider.verified', 'model' => 'Provider', 'model_id' => $providers[0]->id, 'ago' => 90, 'old' => ['status' => 'pending'], 'new' => ['status' => 'approved']],
            ['user' => $admin, 'action' => 'provider.verified', 'model' => 'Provider', 'model_id' => $providers[3]->id, 'ago' => 200, 'old' => ['status' => 'pending'], 'new' => ['status' => 'approved']],
            ['user' => User::where('email', 'julie.dubois@example.fr')->first(), 'action' => 'care_circle.invite', 'model' => 'CareCircle', 'model_id' => 1, 'ago' => 60],
            ['user' => User::where('email', 'marguerite.dubois@example.fr')->first(), 'action' => 'user.register', 'model' => 'User', 'model_id' => 2, 'ago' => 60],
            ['user' => $admin, 'action' => 'company.verified', 'model' => 'Company', 'model_id' => 1, 'ago' => 60, 'old' => ['status' => 'pending'], 'new' => ['status' => 'approved']],
            ['user' => User::where('email', 'henri.lambert@example.fr')->first(), 'action' => 'profile.update', 'model' => 'Beneficiary', 'model_id' => 2, 'ago' => 30, 'old' => ['address' => '42 Ave Victor Hugo'], 'new' => ['address' => '42 Avenue Victor Hugo']],
            ['user' => $admin, 'action' => 'complaint.assigned', 'model' => 'Complaint', 'model_id' => 1, 'ago' => 12],
            ['user' => User::where('email', 'pierre.lambert@example.fr')->first(), 'action' => 'service_request.created', 'model' => 'ServiceRequest', 'model_id' => 2, 'ago' => 5],
        ];

        foreach ($auditActions as $a) {
            AuditLog::create([
                'user_id' => $a['user']->id,
                'action' => $a['action'],
                'model_type' => $a['model'],
                'model_id' => $a['model_id'],
                'old_values' => $a['old'] ?? null,
                'new_values' => $a['new'] ?? null,
                'ip_address' => '192.168.1.' . rand(1, 254),
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'created_at' => now()->subDays($a['ago']),
            ]);
        }
    }

    private function createMessages(Conversation $conv, array $messages): void
    {
        foreach ($messages as $m) {
            Message::create([
                'conversation_id' => $conv->id,
                'sender_id' => $m['sender_id'],
                'content' => $m['content'],
                'attachments' => null,
                'is_read' => $m['ago'] > 2,
                'read_at' => $m['ago'] > 2 ? now()->subDays($m['ago'] - 1) : null,
                'created_at' => now()->subDays($m['ago']),
            ]);
        }
    }
}