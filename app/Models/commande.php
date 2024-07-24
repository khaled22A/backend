<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commande extends Model
{
    use HasFactory;
    protected $table='Commandes';
    protected $fillable =
    [
        'id_client',
        'id_produit',
        'num_commande',
        'date_commande',
        'statut'
        
    ];
}
