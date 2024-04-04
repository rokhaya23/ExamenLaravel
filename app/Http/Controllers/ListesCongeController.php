<?php

namespace App\Http\Controllers;

use App\Models\Category_Conge;
use App\Models\Conge;
use App\Models\Employee;
use App\Models\Gestion_Conge;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListesCongeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:voir_infos', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Vérifier le rôle de l'utilisateur
        if ($user->hasRole('Utilisateur Interne')) {
            // Si l'utilisateur est un utilisateur interne, récupérer uniquement ses propres demandes de congé
            $demandesConge = $user->conges()->with('employees', 'typeConge')->get();
        } else {
            // Si l'utilisateur n'est pas un utilisateur interne, récupérer toutes les demandes de congé
            $demandesConge = Conge::with('employees', 'typeConge')->get();
        }

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

        // Récupérer le nombre de jours restants pour le type de congé sélectionné
        $gestionConge = Gestion_Conge::findOrFail($request->idType_conge);
        $joursUtilises = Conge::where('idType_conge', $request->idType_conge)
            ->where('statut', 'Accepted')
            ->sum('nombre_jour');
        $joursRestants = $gestionConge->jours_autorise - $joursUtilises;

        // Vérifier si le nombre de jours demandés dépasse les jours restants
        if ($request->nombre_jour > $joursRestants) {
            // Rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'Le nombre de jours demandés dépasse les jours restants.');
        }

        // Créer une nouvelle instance de Conge avec les données du formulaire
        $demandeConge = new Conge();
        $demandeConge->idEmployee = Auth::id(); // Identifiant de l'employé connecté
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
        // Récupérer la liste des employés et des types de congé pour le formulaire de modification
        $employees = Employee::get();
        $typesConge = Gestion_Conge::get();

        // Retourner la vue d'édition avec les données de la demande de congé et les listes des employés et des types de congé
        return view('employee.formdemandeconge', compact('demandeConge', 'employees', 'typesConge'));
    }

    public function update(Request $request, Conge $demandeConge)
    {
        // Validation des données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'idType_conge' => 'required|exists:gestion_conges,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'telephone' => 'required|string',
        ]);

        // Calculer le nombre de jours entre la date de début et la date de fin
        $startDate = strtotime($request->date_debut);
        $endDate = strtotime($request->date_fin);
        $diffDays = round(($endDate - $startDate) / (60 * 60 * 24));

        // Mettre à jour les champs de la demande de congé avec les nouvelles données du formulaire
        $demandeConge->update([
            'idEmployee' => $request->idEmployee,
            'idType_conge' => $request->idType_conge,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'telephone' => $request->telephone,
            'nombre_jour' => $diffDays, // Mettre à jour le nombre de jours
        ]);

        // Si le statut de la demande est "Accepted", appeler la méthode pour accepter la demande
        if ($demandeConge->statut === 'Accepted') {
            $this->acceptLeaveRequest($demandeConge->id);
        }

        // Rediriger l'utilisateur vers la page de liste des demandes de congé ou toute autre page appropriée
        return redirect()->route('listes.index')->with('success', 'Leave request successfully updated.');
    }

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

    public function acceptLeaveRequest($id)
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

    public function valider($id)
    {
        $demandeConge = Conge::findOrFail($id);
        // Logic for validating the leave request
        $demandeConge->statut = 'Accepted';
        $demandeConge->save();

        return $this->mesDemandes()->with('success', 'The leave request has been accepted successfully.');
    }

    public function refuser($id)
    {
        $demandeConge = Conge::findOrFail($id);
        // Logic for rejecting the leave request
        $demandeConge->statut = 'Rejected';
        $demandeConge->save();

        return $this->mesDemandes()->with('success', 'The leave request has been rejected successfully.');
    }

    public function mesDemandes()
    {
        $demandesConge = Conge::all();

        return view('employee.listecongeadmin',  compact('demandesConge'));

    }
}
