<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'adresse',
        'telephone',
        'poste',
        'sexe',
        'email',
        'banque',
        'numero_compte',
        'CNI',
        'password',
        'departement',
        'salaire',
        'date_embauche',
        'langues',
        'situation_matrimonial',
    ];

    protected $casts = [
        'langues' => 'array',
    ];

    public function contrats()
    {
        return $this->hasMany(Contrat::class, 'idEmployee');
    }

    public function conges()
    {
        return $this->hasMany(Conge::class, 'idEmployee');
    }
}
