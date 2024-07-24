<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produit extends Model
{
    use HasFactory;
    protected $table ='Produits';    
protected $fillable =
    [
        
        'id_categorie',
        'image',
        'nom',
        'description',
        'quantite',
        'prix',
    ];
}
