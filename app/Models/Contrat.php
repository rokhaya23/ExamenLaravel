<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable =['idEmployee','type_contrat','date_debut','date_fin','renouvellement_auto'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'idEmployee');
    }
}
