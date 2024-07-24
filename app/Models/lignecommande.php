<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lignecommande extends Model
{
    use HasFactory;
    protected $table='LigneCommandes';
    protected $fillable =
    [
        'id_commande',
        'id_produit',
        'quantite',
        'prix',
        'total',
    ];
}
