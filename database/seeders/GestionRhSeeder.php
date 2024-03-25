<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Utilisateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GestionRhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creer des permissions
        $permissions = [
            'gerer_user',
            'gerer_documents',
            'gerer_employees',
            'gerer_contrats',
            'gerer_conges',
            'gestion_conges',
            'category_conges',
            'voir_infos',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        //creer des roles

        $administrateur = Role::create(['name' => 'Administrateur']);
        $gestionnaire = Role::create(['name' => 'Gestionnaire']);
        $utilisateurinterne = Role::create(['name' => 'Utilisateur Interne']);

        $gestionnaire->givePermissionTo([
            'gerer_documents',
            'gerer_employees',
            'gerer_contrats',
            'voir_infos',
        ]);


        $administrateur->givePermissionTo([
            'gerer_user',
            'gerer_documents',
            'gerer_employees',
            'gerer_contrats',
            'gerer_conges',
            'gestion_conges',
            'category_conges',
            'voir_infos',
        ]);

        $utilisateurinterne->givePermissionTo([
            'voir_infos',
        ]);

        //creer des utilisateurs
        $Admin = Utilisateur::create([
            'nom' => 'Beye',
            'prenom' => 'Rokhaya',
            'email' => 'rbeye23@gmail.com',
            'password' => Hash::make('passer@1'),
        ]);
        $Admin->assignRole('Administrateur');


        $gestionnaire = Utilisateur::create([
            'nom' => 'Fall',
            'prenom' => 'Fallou',
            'email' => 'falloufall@gmail.com',
            'password' => Hash::make('passer@2'),
        ]);
        $gestionnaire->assignRole('Gestionnaire');

        $userinterne = Utilisateur::create([
            'nom' => 'sall',
            'prenom' => 'Rokhaya',
            'email' => 'rsall23@gmail.com',
            'password' => Hash::make('passer@3'),
        ]);
        $userinterne->assignRole('Utilisateur Interne');


    }
}
