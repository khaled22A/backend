<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class panier extends Model
{
    use HasFactory;
    protected $table ='Paniers';    
    protected $fillable =
        [
            'id_client',
            'id_produit',
            'quantite',
            'prix',
        ];
}
