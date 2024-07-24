<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    use HasFactory;
    protected $table='Paiements';
    protected $fillable=
    [
        'id_client',
        'total',
        'methode_paiement',
        'date_paiement',
        'statut',

    
    ];
}
