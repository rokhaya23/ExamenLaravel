<?php

namespace App\Http\Controllers;

use App\Models\Category_Conge;
use App\Models\Conge;
use App\Models\Gestion_Conge;
use Illuminate\Http\Request;

class CategorieConge extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $idEmployee = auth()->user()->id;
            $conges = Conge::where('idEmployee', $idEmployee)->get();
            $gestionConges = Gestion_Conge::all();

            // Calculating remaining days for each type of leave
            $remainingDays = [];
            foreach ($gestionConges as $gestionConge) {
                $typeConge = $gestionConge->type_conge;
                $joursAutorise = $gestionConge->jours_autorise;
                $congesForType = $conges->where('idType_conge', $typeConge);
                $joursUtilise = $congesForType->sum('nombre_jour');
                $remainingDays[$typeConge] = $joursAutorise - $joursUtilise;
            }

            return view('category_conge.index', compact('conges', 'remainingDays'));
        } else {
            // L'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion
            return redirect()->route('users.login');
        }
    }
}
