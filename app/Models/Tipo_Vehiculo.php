<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Vehiculo extends Model
{
    use HasFactory;
    protected $table = "tipo_vehiculo";
    protected $fillable = [
        'nombre_vehiculo'
    ];
}
