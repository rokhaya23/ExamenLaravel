<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion_Conge extends Model
{
    use HasFactory;

    protected $table = 'gestion_conges';

    protected $fillable =['type_conge','paiement','jours_autorise'];

    public function categoryConges()
    {
        return $this->hasOne(Category_Conge::class, 'idType_conge');
    }

    public function congees()
    {
        return $this->hasMany(Conge::class, 'idType_conge');
    }
}
