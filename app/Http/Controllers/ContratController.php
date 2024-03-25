<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Employee;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_contrats', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        $contrats = Contrat::with('employee')->get();
        $employees = Employee::all();
        return view('contrat.index', compact('employees','contrats'));
    }

    public function create()
    {
        // Récupérer tous les employés pour afficher dans le formulaire de création
        $employees = Employee::all();
        $contrat = new Contrat();
        // Retourner la vue du formulaire de création avec les employés
        return view('contrat.form', compact('employees','contrat'));
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'type_contrat' => 'required|string',
            'date_debut' => 'required_if:type_contrat,!=,CDI|date',
        ]);

        // Si le contrat est CDI, les dates ne sont pas nécessaires
        if ($request->type_contrat === 'CDI') {
            $request->request->remove('date_fin');
        }

        // Créer un nouveau contrat avec les données fournies
        $contrat = Contrat::create($request->all());

        // Récupérer l'employé associé au contrat
        $employee = Employee::findOrFail($request->idEmployee);

        // Rediriger avec un message de succès
        return redirect()->route('contrats.index')->with('success', 'Contrat added successfully.');
    }

    public function edit(Contrat $contrat)
    {
        $employees = Employee::all();
        return view('contrat.form', compact('contrat', 'employees'));
    }

    public function update(Request $request, Contrat $contrat)
    {
        // Valider les données du formulaire
        $request->validate([
            'idEmployee' => 'required|exists:employees,id',
            'type_contrat' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'renouvellement_auto' => 'boolean',
        ]);

        // Mettre à jour le contrat avec les données fournies
        $contrat->update($request->all());

        // Rediriger avec un message de succès
        return redirect()->route('contrats.index')->with('success', 'Contrat updated successfully.');
    }

    public function destroy(Contrat $contrat)
    {
        $contrat->delete();
        return redirect()->route('contrats.index')->with('success', 'Contrat deleted successfully.');
    }
}
