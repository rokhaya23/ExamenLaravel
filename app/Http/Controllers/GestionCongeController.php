<?php

namespace App\Http\Controllers;

use App\Models\Gestion_Conge;
use Illuminate\Http\Request;

class GestionCongeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:gerer_conge', ['only' => ['index','show','create','update','store','edit','destroy']]);
    }

    public function index()
    {
        $conges = Gestion_Conge::all(); // Remplacez Conge par le nom de votre modèle Congé
        return view('gestion_conge.index', compact('conges'));
    }

    public function create()
    {
        $conge = new Gestion_Conge();
        return view('gestion_conge.form',compact('conge'));
    }

    // Méthode pour traiter le formulaire de création
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'type_conge' => 'required|string',
            'paiement' => 'required|in:paid,unpaid',
            'jours_autorise' => 'required|integer',
        ]);

        // Création d'une nouvelle instance de Conge avec les données du formulaire
        $conge = new Gestion_Conge();
        $conge->type_conge = $request->type_conge;
        $conge->paiement = $request->paiement;
        $conge->jours_autorise = $request->jours_autorise;

        // Sauvegarde du Conge dans la base de données
        $conge->save();

        // Redirection avec un message de succès
        return redirect()->route('conges.index')->with('success', 'Congé créé avec succès!');
    }
    public function edit(Gestion_Conge $conge)
    {
        return view('gestion_conge.form', compact('conge'));
    }

    public function update(Request $request, Gestion_Conge $conge)
    {
        $request->validate([
            'type_conge' => 'required|string',
            'paiement' => 'required|in:paid,unpaid',
            'jours_autorise' => 'required|integer',
        ]);

        $conge->update([
            'type_conge' => $request->type_conge,
            'paiement' => $request->paiement,
            'jours_autorise' => $request->jours_autorise,
        ]);

        return redirect()->route('conges.index')->with('success', 'Congé mis à jour avec succès!');
    }
    public function destroy(Gestion_Conge $conge)
    {
        $conge->delete();

        return redirect()->route('conges.index')->with('success', 'Congé supprimé avec succès!');
    }


}
