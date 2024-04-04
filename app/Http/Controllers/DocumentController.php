<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $documentsattest=Document::where('type','attestation')->get();
//        $doccontrat=Document::where('type','contrat')->get();

        return view('document.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function attestation()
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            // Récupérer l'utilisateur authentifié
            $employee = Auth::user();

            // Charger la vue PDF avec les données de l'employé
            $pdf = PDF::loadView('document.attestation', compact('employee'));

            // Télécharger le PDF
            return $pdf->download('Attestation_de_travail.pdf');
        } else {
            // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette fonctionnalité.');
        }
    }
    public function contrat()
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Vérifier si l'utilisateur a un contrat
            $contrat = $user->contrats()->first();

            // Vérifier si un contrat a été trouvé
            if ($contrat) {
                // Charger la vue PDF avec les données du contrat et de l'utilisateur
                $pdf = PDF::loadView('document.contrat_travail', compact('contrat', 'user'));

                // Télécharger le PDF
                return $pdf->download('contrat_de_travail.pdf');
            } else {
                // Si aucun contrat n'a été trouvé, afficher un message d'erreur
                return back()->with('error', 'Aucun contrat trouvé pour cet utilisateur.');
            }
        } else {
            // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette fonctionnalité.');
        }
    }
    public function leave()
    {
        $contrat=Contrat::where('idEmployee',Auth::user()->id)->first();
        $pdf = PDF::loadView('document.conge', array('conge' =>  $contrat));

        return $pdf->download('demande_de_conge.pdf');

    }
}
