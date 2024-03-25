<?php

namespace App\Http\Controllers;

use App\Models\Category_Conge;
use App\Models\Conge;
use App\Models\Employee;
use App\Models\Gestion_Conge;
use Illuminate\Http\Request;

class ListesCongeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_conges', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }
    public function index()
    {
        // Récupérer toutes les demandes de congé avec les informations de l'employé et du type de congé associés
        $demandesConge = Conge::with('employees', 'typeConge')->get();
        return view('employee.listeconge', compact('demandesConge'));
    }

    public function create()
    {
        // Créer une nouvelle instance de Conge vide pour le formulaire de création
        $demandeConge = new Conge();

        // Récupérer la liste des employés et des types de congé pour le formulaire de création
        $employees = Employee::all();
        $typesConge = Gestion_Conge::all();

        // Retourner la vue du formulaire de création avec les données nécessaires
        return view('employee.formdemandeconge', compact('demandeConge', 'employees', 'typesConge'));
    }


    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'idType_conge' => 'required|exists:gestion_conges,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'telephone' => 'required|string', // Validation du numéro de téléphone
            // Autres règles de validation...
        ]);

        // Créer une nouvelle instance de Conge avec les données du formulaire
        $demandeConge = new Conge();
        $demandeConge->idEmployee = $request->idEmployee;
        $demandeConge->idType_conge = $request->idType_conge;
        $demandeConge->date_debut = $request->date_debut;
        $demandeConge->date_fin = $request->date_fin;
        $demandeConge->telephone = $request->telephone; // Ajouter le numéro de téléphone à la demande de congé

        // Calcul automatique du nombre de jours
        $startDate = strtotime($request->date_debut);
        $endDate = strtotime($request->date_fin);
        $diffDays = round(($endDate - $startDate) / (60 * 60 * 24));
        $demandeConge->nombre_jour = $diffDays;

        // Enregistrer la demande de congé
        $demandeConge->save();

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('listes.index')->with('success', 'Leave request successfully created.');
    }

    public function edit(Conge $demandeConge)
    {
        // Charger la demande de congé spécifique avec les informations de l'employé et du type de congé associés
        $demandeConge->load('employees', 'typeConge');

        // Récupérer la liste des employés et des types de congé pour le formulaire de modification
        $employees = Employee::all();
        $typesConge = Gestion_Conge::all();

        // Retourner la vue d'édition avec les données de la demande de congé et les listes des employés et des types de congé
        return view('employee.formdemandeconge', compact('demandeConge', 'employees', 'typesConge'));
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
            'telephone' => 'required|string', // Validation du numéro de téléphone
            // Autres règles de validation...
        ]);

        // Mettre à jour les champs de la demande de congé avec les nouvelles données du formulaire
        $demandeConge->update([
            'idEmployee' => $request->idEmployee,
            'idType_conge' => $request->idType_conge,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'telephone' => $request->telephone, // Mettre à jour le numéro de téléphone
            // Mettre à jour le nombre de jours si nécessaire
        ]);

        if ($demandeConge->statut === 'Accepted') {
            $this->acceptLeaveRequest($demandeConge);
        }
        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('listes.index')->with('success', 'Leave request successfully updated.');
    }


    // Méthode pour supprimer une demande de congé
    public function destroy(Conge $demandeConge)
    {
        // Supprimer la demande de congé
        $demandeConge->delete();

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('listes.index')->with('success', 'Leave request successfully deleted.');
    }


    public function getPhoneNumber($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee) {
            return response()->json(['phoneNumber' => $employee->telephone]);
        } else {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }

    public function acceptLeaveRequest(Request $request, $id)
    {
        // Récupérez la demande de congé
        $demandeConge = Conge::findOrFail($id);

        // Vérifiez si la demande est déjà acceptée
        if ($demandeConge->statut === 'Accepted') {
            // Récupérez la catégorie de congé correspondante
            $categorieConge = Category_Conge::where('idType_conge', $demandeConge->idType_conge)->first();

            // Assurez-vous que la catégorie de congé existe
            if ($categorieConge) {
                // Décrémentez les jours utilisés dans la catégorie correspondante
                $categorieConge->jours_utiliser -= $demandeConge->nombre_jour;
                $categorieConge->jours_restant += $demandeConge->nombre_jour;
                $categorieConge->save();
            }
        }

        // Mettez à jour le statut de la demande de congé
        $demandeConge->statut = 'Accepted';
        $demandeConge->save();
    }
}
