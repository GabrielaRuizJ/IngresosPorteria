<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table="club";
    use HasFactory;
    protected $fillable = [
        'nombre_club',
        'direccion',
        'telefono',
        'email1',
        'id_ciudad'
    ];
}
