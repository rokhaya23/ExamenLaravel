<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employee;
use App\Models\Gestion_Conge;
use Illuminate\Http\Request;

class ListesCongeController extends Controller
{
    public function index()
    {
        // Récupérer toutes les demandes de congé avec les informations de l'employé et du type de congé associés
        $demandesConge = Conge::with('employees', 'typeConge')->get();
        return view('employee.listeconge', compact('demandesConge'));
    }

    public function create()
    {
        // Récupérer la liste des employés et des types de congé pour le formulaire de création
        $employees = Employee::all();
        $typesConge = Gestion_Conge::all();
        return view('employee.formdemandeconge', compact('employees', 'typesConge'));
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'idType_conge' => 'required|exists:gestion_conges,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            // Autres règles de validation...
        ]);

        // Créer une nouvelle instance de DemandeConge avec les données du formulaire
        $demandeConge = new Conge();
        $demandeConge->idEmployee = $request->idEmployee;
        $demandeConge->idType_conge = $request->idType_conge;
        $demandeConge->date_debut = $request->date_debut;
        $demandeConge->date_fin = $request->date_fin;
        // Calcul automatique du nombre de jours
        $startDate = strtotime($request->date_debut);
        $endDate = strtotime($request->date_fin);
        $diffDays = round(($endDate - $startDate) / (60 * 60 * 24));
        $demandeConge->nombre_jour = $diffDays;
        // Si le numéro de téléphone est fourni dans la demande, vous pouvez l'ajouter ici

        // Enregistrer la demande de congé
        $demandeConge->save();

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('employee.listeconge')->with('success', 'Demande de congé créée avec succès.');
    }
    public function edit(Conge $demandeConge)
    {
        // Récupérer la demande de congé spécifique avec les informations de l'employé et du type de congé associés
        $demandeConge->load('employee', 'typeConge');

        // Récupérer la liste des employés et des types de congé pour le formulaire de modification
        $employees = Employee::all();
        $typesConge = Gestion_Conge::all();

        // Retourner la vue d'édition avec les données de la demande de congé et les listes des employés et des types de congé
        return view('formdemandeconge', compact('demandeConge', 'employees', 'typesConge'));
    }

    // Méthode pour afficher les détails d'une demande de congé
    public function show(Conge $demandeConge)
    {
        // Récupérer la demande de congé spécifique avec les informations de l'employé et du type de congé associés
        $demandeConge->load('employee', 'typeConge');

        // Retourner la vue des détails de la demande de congé avec les données de la demande de congé
        return view('employee.show', compact('demandeConge'));
    }

    // Méthode pour mettre à jour une demande de congé
    public function update(Request $request, Conge $demandeConge)
    {
        // Validation des données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'idType_conge' => 'required|exists:gestion_conges,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            // Autres règles de validation...
        ]);

        // Mettre à jour les champs de la demande de congé avec les nouvelles données du formulaire
        $demandeConge->update([
            'idEmployee' => $request->idEmployee,
            'idType_conge' => $request->idType_conge,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            // Mettre à jour le nombre de jours si nécessaire
        ]);

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('employee.listeconge')->with('success', 'Demande de congé mise à jour avec succès.');
    }

    // Méthode pour supprimer une demande de congé
    public function destroy(Conge $demandeConge)
    {
        // Supprimer la demande de congé
        $demandeConge->delete();

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('employee.listeconge')->with('success', 'Demande de congé supprimée avec succès.');
    }


    public function getPhoneNumber($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return response()->json(['phoneNumber' => $employee->telephone]);
        } else {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }
}
