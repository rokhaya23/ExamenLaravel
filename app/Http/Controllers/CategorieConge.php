<?php

namespace App\Http\Controllers;

use App\Models\Category_Conge;
use App\Models\Conge;
use App\Models\Gestion_Conge;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class CategorieConge extends Controller
{
    public function index()
    {
        $idEmployee = auth()->user()->id; // Supposons que vous utilisez l'authentification par défaut de Laravel

        // Récupérer les demandes de congé de l'employé
        $demandesConges = Conge::where('idEmployee', $idEmployee)->get();

        // Récupérer les informations sur les types de congé et les jours autorisés
        $gestionConges = Gestion_Conge::all();


        return view('category_conge.index',  compact('demandesConges', 'gestionConges'));

    }

    public function telechargerPdfDemandeConge($id)
    {
        $demandeConge = Conge::findOrFail($id); // Supposons que vous avez un modèle Conge pour représenter les demandes de congé

        // Générer le PDF en utilisant une vue spécifique pour la demande de congé
        $pdf = PDF::loadView('employee.pdf', compact('demandeConge'));

        // Télécharger le PDF
        return $pdf->download('demande_conge.pdf');
    }
}
