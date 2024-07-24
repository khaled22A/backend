<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commune extends Model
{
    use HasFactory;
    protected $table='Communes';
    protected $fillable =
    [
        'id_wilaya',
        'nom',
        'code_postal',
    ];
}
