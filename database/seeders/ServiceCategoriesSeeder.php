<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // === home_care_assistant — 12 categories ===
            ['name' => 'Aide à la toilette et habillage', 'icon' => 'shower', 'color' => '#4A90D9', 'profession' => 'home_care_assistant'],
            ['name' => 'Aide aux repas et préparation', 'icon' => 'utensils', 'color' => '#F5A623', 'profession' => 'home_care_assistant'],
            ['name' => 'Aide au lever et au coucher', 'icon' => 'bed', 'color' => '#7B68EE', 'profession' => 'home_care_assistant'],
            ['name' => 'Aide à la mobilité et transferts', 'icon' => 'wheelchair', 'color' => '#50C878', 'profession' => 'home_care_assistant'],
            ['name' => 'Entretien du logement', 'icon' => 'broom', 'color' => '#9B59B6', 'profession' => 'home_care_assistant'],
            ['name' => 'Gestion du linge et du vestiaire', 'icon' => 'tshirt', 'color' => '#FF8C42', 'profession' => 'home_care_assistant'],
            ['name' => 'Aide aux courses et approvisionnement', 'icon' => 'shopping-cart', 'color' => '#E74C3C', 'profession' => 'home_care_assistant'],
            ['name' => 'Accompagnement aux rendez-vous', 'icon' => 'car', 'color' => '#3498DB', 'profession' => 'home_care_assistant'],
            ['name' => 'Aide aux démarches administratives', 'icon' => 'file-text', 'color' => '#1ABC9C', 'profession' => 'home_care_assistant'],
            ['name' => 'Stimulation cognitive et loisirs', 'icon' => 'puzzle-piece', 'color' => '#F39C12', 'profession' => 'home_care_assistant'],
            ['name' => 'Promenade et activités extérieures', 'icon' => 'tree', 'color' => '#2ECC71', 'profession' => 'home_care_assistant'],
            ['name' => 'Veille nocturne et présence', 'icon' => 'moon', 'color' => '#8E44AD', 'profession' => 'home_care_assistant'],

            // === nurse — 8 categories ===
            ['name' => 'Soins infirmiers sur prescription', 'icon' => 'syringe', 'color' => '#E74C3C', 'profession' => 'nurse'],
            ['name' => 'Pansements et plaies', 'icon' => 'band-aid', 'color' => '#C0392B', 'profession' => 'nurse'],
            ['name' => 'Injections et perfusions', 'icon' => 'syringe', 'color' => '#E74C3C', 'profession' => 'nurse'],
            ['name' => 'Surveillance des constantes', 'icon' => 'heart-pulse', 'color' => '#E91E63', 'profession' => 'nurse'],
            ['name' => 'Préparation et distribution de médicaments', 'icon' => 'pills', 'color' => '#FF5722', 'profession' => 'nurse'],
            ['name' => 'Soins palliatifs à domicile', 'icon' => 'bed-pulse', 'color' => '#8E44AD', 'profession' => 'nurse'],
            ['name' => 'Soins post-opératoires', 'icon' => 'hospital', 'color' => '#D32F2F', 'profession' => 'nurse'],
            ['name' => 'Éducation thérapeutique et autonomie', 'icon' => 'graduation-cap', 'color' => '#F57C00', 'profession' => 'nurse'],

            // === physician — 7 categories ===
            ['name' => 'Consultation médicale à domicile', 'icon' => 'stethoscope', 'color' => '#1565C0', 'profession' => 'physician'],
            ['name' => 'Bilan de santé gériatrique', 'icon' => 'clipboard-check', 'color' => '#1976D2', 'profession' => 'physician'],
            ['name' => 'Gestion des traitements chroniques', 'icon' => 'pills', 'color' => '#0288D1', 'profession' => 'physician'],
            ['name' => 'Téléconsultation médicale', 'icon' => 'video', 'color' => '#03A9F4', 'profession' => 'physician'],
            ['name' => 'Renouvellement d\'ordonnances', 'icon' => 'prescription', 'color' => '#42A5F5', 'profession' => 'physician'],
            ['name' => 'Coordination avec spécialistes', 'icon' => 'network-wired', 'color' => '#1E88E5', 'profession' => 'physician'],
            ['name' => 'Certificats médicaux et attestations', 'icon' => 'file-medical', 'color' => '#5C6BC0', 'profession' => 'physician'],

            // === physiotherapist — 4 categories ===
            ['name' => 'Rééducation motrice et marches', 'icon' => 'walking', 'color' => '#00BCD4', 'profession' => 'physiotherapist'],
            ['name' => 'Massages et soulagement des douleurs', 'icon' => 'hands', 'color' => '#00ACC1', 'profession' => 'physiotherapist'],
            ['name' => 'Renforcement musculaire et prévention chutes', 'icon' => 'dumbbell', 'color' => '#0097A7', 'profession' => 'physiotherapist'],
            ['name' => 'Mobilité et transferts au domicile', 'icon' => 'wheelchair', 'color' => '#00838F', 'profession' => 'physiotherapist'],

            // === occupational_therapist — 4 categories ===
            ['name' => 'Évaluation et aménagement du domicile', 'icon' => 'home', 'color' => '#8BC34A', 'profession' => 'occupational_therapist'],
            ['name' => 'Apprentissage des aides techniques', 'icon' => 'tools', 'color' => '#689F38', 'profession' => 'occupational_therapist'],
            ['name' => 'Autonomie dans les AVQ', 'icon' => 'utensils', 'color' => '#558B2F', 'profession' => 'occupational_therapist'],
            ['name' => 'Stimulation sensorielle et cognitive', 'icon' => 'brain', 'color' => '#33691E', 'profession' => 'occupational_therapist'],

            // === speech_therapist — 4 categories ===
            ['name' => 'Rééducation du langage et de la parole', 'icon' => 'comment-medical', 'color' => '#9C27B0', 'profession' => 'speech_therapist'],
            ['name' => 'Rééducation de la déglutition', 'icon' => 'utensils', 'color' => '#8E24AA', 'profession' => 'speech_therapist'],
            ['name' => 'Stimulation cognitive', 'icon' => 'brain', 'color' => '#7B1FA2', 'profession' => 'speech_therapist'],
            ['name' => 'Aide à la communication alternative', 'icon' => 'comments', 'color' => '#6A1B9A', 'profession' => 'speech_therapist'],

            // === social_worker — 4 categories ===
            ['name' => 'Évaluation sociale et médicosociale', 'icon' => 'clipboard-list', 'color' => '#FF9800', 'profession' => 'social_worker'],
            ['name' => 'Aide aux démarches administratives', 'icon' => 'file-text', 'color' => '#F57C00', 'profession' => 'social_worker'],
            ['name' => 'Coordination de parcours et orientations', 'icon' => 'route', 'color' => '#EF6C00', 'profession' => 'social_worker'],
            ['name' => 'Accompagnement social et soutien psychosocial', 'icon' => 'hands-helping', 'color' => '#E65100', 'profession' => 'social_worker'],
        ];

        $subcategoriesMap = [
            'Aide à la toilette et habillage' => ['Toilette complète', 'Toilette partielle', 'Habillage', 'Coiffage et rasage'],
            'Aide aux repas et préparation' => ['Préparation des repas', 'Aide pendant le repas', 'Adaptation du régime alimentaire', 'Hydratation'],
            'Aide au lever et au coucher' => ['Lever matinal', 'Coucher du soir', 'Sieste', 'Installation confortable'],
            'Aide à la mobilité et transferts' => ['Transfert lit-fauteuil', 'Déplacements intérieurs', 'Aide à la marche', 'Utilisation d\'aides techniques'],
            'Entretien du logement' => ['Ménage quotidien', 'Grand ménage', 'Rangement', 'Désinfection'],
            'Gestion du linge et du vestiaire' => ['Lavage du linge', 'Repassage', 'Rangement vestiaire', 'Adaptation tenues'],
            'Aide aux courses et approvisionnement' => ['Courses alimentaires', 'Commande en ligne', 'Livraison repas', 'Gestion stocks'],
            'Accompagnement aux rendez-vous' => ['RDV médicaux', 'RDV administratifs', 'Sorties sociales', 'Démarches en mairie'],
            'Aide aux démarches administratives' => ['Courrier et factures', 'Assurance et mutuelle', 'Impôts', 'CPAM et retraite'],
            'Stimulation cognitive et loisirs' => ['Jeux de société', 'Lecture et écriture', 'Ateliers mémoire', 'Activités manuelles'],
            'Promenade et activités extérieures' => ['Promenade au parc', 'Sortie au marché', 'Jardinage adapté', 'Activité physique adaptée'],
            'Veille nocturne et présence' => ['Veille fixe', 'Veille itinérante', 'Présence rassurante', 'Aide aux toilettes nocturnes'],
            'Soins infirmiers sur prescription' => ['Injection d\'insuline', 'Traitement anticoagulant', 'Soins de cathéter', 'Pansement simple'],
            'Pansements et plaies' => ['Plaie aiguë', 'Plaie chronique', 'Escarres', 'Ulcère de jambe'],
            'Injections et perfusions' => ['Sous-cutanée', 'Intramusculaire', 'Intraveineuse', 'Perfusion continue'],
            'Surveillance des constantes' => ['Tension artérielle', 'Glycémie', 'Saturation en oxygène', 'Température et pouls'],
            'Préparation et distribution de médicaments' => ['Pilulier hebdomadaire', 'Distribution journalière', 'Vérification ordonnance', 'Surveillance effets secondaires'],
            'Soins palliatifs à domicile' => ['Contrôle de la douleur', 'Soins de confort', 'Accompagnement psychologique', 'Coordination avec l\'équipe'],
            'Soins post-opératoires' => ['Pansement post-chirurgical', 'Retrait de points', 'Surveillance cicatrisation', 'Rééducation post-op'],
            'Éducation thérapeutique et autonomie' => ['Auto-surveillance', 'Apprentissage gestes techniques', 'Gestion du traitement', 'Prévention des complications'],
            'Consultation médicale à domicile' => ['Examen clinique général', 'Évaluation gériatrique', 'Diagnostic et avis', 'Orientation et adressage'],
            'Bilan de santé gériatrique' => ['Évaluation cognitive (MMSE)', 'Évaluation de l\'autonomie (IADL/ADL)', 'Bilan nutritionnel', 'Évaluation du risque de chute'],
            'Gestion des traitements chroniques' => ['Diabète', 'Hypertension', 'Insuffisance cardiaque', 'Maladies respiratoires'],
            'Téléconsultation médicale' => ['Suivi de pathologie chronique', 'Renouvellement ordonnance', 'Interprétation d\'examen', 'Avis sur symptôme'],
            'Renouvellement d\'ordonnances' => ['Médicaments chroniques', 'Matériel médical', 'Soins infirmiers', 'Kinésithérapie'],
            'Coordination avec spécialistes' => ['Cardiologie', 'Neurologie', 'Rhumatologie', 'Psychiatrie'],
            'Certificats médicaux et attestations' => ['Certificat médical', 'Aptitude au portage', 'Incapacité', 'Certificat de décès'],
            'Rééducation motrice et marches' => ['Marche et équilibre', 'Rééducation membre inférieur', 'Rééducation membre supérieur', 'Réapprentissage de la marche'],
            'Massages et soulagement des douleurs' => ['Massage thérapeutique', 'Drainage lymphatique', 'Libération myofasciale', 'Techniques antalgiques'],
            'Renforcement musculaire et prévention chutes' => ['Renforcement des membres inférieurs', 'Travail de l\'équilibre', 'Programme Otago', 'Prévention de la chute'],
            'Mobilité et transferts au domicile' => ['Transferts sécurisés', 'Aménagement de l\'environnement', 'Apprentissage aides techniques', 'Conseils ergonomiques'],
            'Évaluation et aménagement du domicile' => ['Évaluation des besoins', 'Plan d\'aménagement', 'Recommandation d\'aides techniques', 'Suivi des adaptations'],
            'Apprentissage des aides techniques' => ['Déambulateur', 'Fauteuil roulant', 'Aides au transfert', 'Aides à la toilette'],
            'Autonomie dans les AVQ' => ['Habillage', 'Toilette', 'Repas', 'Déplacements intérieurs'],
            'Stimulation sensorielle et cognitive' => ['Ateliers sensoriels', 'Jeux cognitifs adaptés', 'Rééducation attentionnelle', 'Stimulation mnésique'],
            'Rééducation du langage et de la parole' => ['Aphasie', 'Dysarthrie', 'Bégaiement acquis', 'Rééducation vocale'],
            'Rééducation de la déglutition' => ['Dysphagie orale', 'Dysphagie pharyngée', 'Adaptation des textures', 'Prévention des fausses routes'],
            'Stimulation cognitive' => ['Mémoire', 'Attention', 'Fonctions exécutives', 'Langage'],
            'Aide à la communication alternative' => ['Communication augmentée', 'Outils numériques', 'Tableaux de communication', 'Formation de l\'entourage'],
            'Évaluation sociale et médicosociale' => ['Évaluation des besoins', 'Analyse du domicile', 'Situation financière', 'Réseau de soutien'],
            'Aide aux démarches administratives' => ['Dossier APA', 'Dossier ALD', 'Demande de prestation', 'Recours et réclamations'],
            'Coordination de parcours et orientations' => ['Orientation vers services', 'Coordination avec médecins', 'Plan d\'aide personnalisé', 'Suivi des orientations'],
            'Accompagnement social et soutien psychosocial' => ['Soutien psychologique', 'Lien familial', 'Groupes de parole', 'Prévention de l\'isolement'],
        ];

        $sortOrder = 0;
        foreach ($categories as $cat) {
            $name = $cat['name'];
            ServiceCategory::create([
                'name' => $name,
                'slug' => Str::slug($cat['profession'] . '-' . $name),
                'icon' => $cat['icon'],
                'color' => $cat['color'],
                'description' => $this->getDescription($name),
                'subcategories' => $subcategoriesMap[$name] ?? [],
                'profession' => $cat['profession'],
                'is_predefined' => true,
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function getDescription(string $name): string
    {
        $descriptions = [
            'Aide à la toilette et habillage' => 'Accompagnement pour la toilette, l\'hygiène corporelle et l\'habillage, avec respect de l\'intimité et de la dignité.',
            'Aide aux repas et préparation' => 'Préparation des repas adaptés au régime, aide pendant le repas et surveillance de l\'hydratation.',
            'Aide au lever et au coucher' => 'Assistance pour le lever matinal et le coucher, installation confortable et sécurisée.',
            'Aide à la mobilité et transferts' => 'Aide aux déplacements et transferts (lit-fauteuil, marche), utilisation d\'aides techniques.',
            'Entretien du logement' => 'Entretien courant du domicile : ménage, rangement, désinfection, pour un environnement sain.',
            'Gestion du linge et du vestiaire' => 'Lavage, repassage et rangement du linge personnel, adaptation des tenues selon la saison.',
            'Aide aux courses et approvisionnement' => 'Réalisation des courses alimentaires, commandes en ligne, gestion des stocks alimentaires.',
            'Accompagnement aux rendez-vous' => 'Accompagnement aux rendez-vous médicaux, administratifs et sorties sociales.',
            'Aide aux démarches administratives' => 'Aide au tri du courrier, gestion des factures, démarches CPAM, impôts, retraite et assurance.',
            'Stimulation cognitive et loisirs' => 'Activités ludiques et cognitives adaptées : jeux, lecture, ateliers mémoire, activités manuelles.',
            'Promenade et activités extérieures' => 'Promenades au parc, sorties au marché, jardinage adapté, activité physique douce en extérieur.',
            'Veille nocturne et présence' => 'Présence nocturne rassurante, veille fixe ou itinérante, aide aux toilettes nocturnes.',
            'Soins infirmiers sur prescription' => 'Soins infirmiers techniques réalisés sur prescription médicale : injections, prélèvements, traitements.',
            'Pansements et plaies' => 'Soins de plaies aiguës et chroniques, pansements spécialisés, surveillance de la cicatrisation.',
            'Injections et perfusions' => 'Administration d\'injections et perfusions selon prescription, surveillance et éducation à l\'auto-administration.',
            'Surveillance des constantes' => 'Mesure et surveillance des constantes vitales : TA, glycémie, saturation, température, pouls.',
            'Préparation et distribution de médicaments' => 'Préparation des piluliers, distribution des médicaments, vérification de l\'observance thérapeutique.',
            'Soins palliatifs à domicile' => 'Soins de confort, contrôle de la douleur, accompagnement psychologique en phase palliative.',
            'Soins post-opératoires' => 'Soins après hospitalisation : pansements, surveillance, coordination avec l\'équipe hospitalière.',
            'Éducation thérapeutique et autonomie' => 'Formation à l\'auto-surveillance et à la gestion du traitement, prévention des complications.',
            'Consultation médicale à domicile' => 'Examen clinique, évaluation globale, diagnostic et orientation par un médecin à domicile.',
            'Bilan de santé gériatrique' => 'Évaluation gériatrique multidimensionnelle : cognition, autonomie, nutrition, risque de chute.',
            'Gestion des traitements chroniques' => 'Suivi et ajustement des traitements pour pathologies chroniques : diabète, HTA, insuffisance cardiaque.',
            'Téléconsultation médicale' => 'Consultation à distance pour suivi de pathologie, renouvellement d\'ordonnance, avis sur symptôme.',
            'Renouvellement d\'ordonnances' => 'Renouvellement des prescriptions médicales : médicaments, soins infirmiers, matériel médical.',
            'Coordination avec spécialistes' => 'Liaison avec les spécialistes : cardiologie, neurologie, rhumatologie, coordination du parcours de soins.',
            'Certificats médicaux et attestations' => 'Rédaction de certificats médicaux, attestations d\'incapacité, certificats spécifiques.',
            'Rééducation motrice et marches' => 'Rééducation de la motricité, de la marche et de l\'équilibre après hospitalisation ou blessure.',
            'Massages et soulagement des douleurs' => 'Techniques de massage et de drainage pour soulager douleurs musculaires et articulaires.',
            'Renforcement musculaire et prévention chutes' => 'Programme de renforcement musculaire et d\'équilibre pour prévenir les chutes chez les seniors.',
            'Mobilité et transferts au domicile' => 'Optimisation des transferts et déplacements au domicile, conseils ergonomiques et aides techniques.',
            'Évaluation et aménagement du domicile' => 'Évaluation des besoins d\'adaptation du logement et recommandation d\'aides techniques.',
            'Apprentissage des aides techniques' => 'Formation à l\'utilisation des aides techniques : déambulateur, fauteuil, aides au transfert.',
            'Autonomie dans les AVQ' => 'Travail sur l\'autonomie dans les activités de la vie quotidienne : habillage, toilette, repas.',
            'Stimulation sensorielle et cognitive' => 'Ateliers de stimulation sensorielle et cognitive pour maintenir les fonctions mentales.',
            'Rééducation du langage et de la parole' => 'Rééducation des troubles du langage parlé : aphasie, dysarthrie, bégaiement acquis.',
            'Rééducation de la déglutition' => 'Rééducation des troubles de la déglutition et prévention des fausses routes.',
            'Stimulation cognitive' => 'Exercices ciblés sur la mémoire, l\'attention et les fonctions exécutives.',
            'Aide à la communication alternative' => 'Mise en place d\'outils de communication alternative pour les troubles sévères du langage.',
            'Évaluation sociale et médicosociale' => 'Évaluation globale de la situation sociale et médicosociale du bénéficiaire.',
            'Aide aux démarches administratives' => 'Accompagnement dans les démarches : APA, ALD, prestations sociales, recours et réclamations.',
            'Coordination de parcours et orientations' => 'Coordination du parcours de santé et orientation vers les services et dispositifs adaptés.',
            'Accompagnement social et soutien psychosocial' => 'Soutien psychosocial, prévention de l\'isolement, aide au maintien du lien familial et social.',
        ];

        return $descriptions[$name] ?? 'Service d\'accompagnement professionnel à domicile.';
    }
}