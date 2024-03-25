<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Conge extends Model
{
    use HasFactory;
    protected $table = 'categorie_conges';
    protected $fillable = [
        'idType_conge',
        'paiement',
        'jours_autorise',
        'jours_utiliser',
        'jours_restant',
    ];

    public function typeConges()
    {
        return $this->belongsTo(Gestion_Conge::class, 'idType_conge');
    }


}
