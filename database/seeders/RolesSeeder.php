<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'label' => 'Administrateur', 'description' => 'Accès complet au système, gestion des utilisateurs et configuration'],
            ['name' => 'beneficiary', 'label' => 'Bénéficiaire', 'description' => 'Personne recevant des soins ou services à domicile'],
            ['name' => 'caregiver', 'label' => 'Aidant', 'description' => 'Membre de l\'entourage du bénéficiaire (famille, proche)'],
            ['name' => 'provider', 'label' => 'Intervenant', 'description' => 'Professionnel de santé ou d\'aide à domicile'],
            ['name' => 'company_manager', 'label' => 'Gestionnaire de structure', 'description' => 'Responsable d\'une entreprise de services à domicile'],
            ['name' => 'employee', 'label' => 'Salarié', 'description' => 'Employé d\'une structure de services, rattaché à un gestionnaire'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}