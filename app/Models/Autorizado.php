<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizado extends Model
{
    use HasFactory;
    protected $table = 'ciudad';
    protected $fillable = [
        'cedula_autorizado',
        'nombre_autorizado',
        'cedula_autoriza',
        'nombre_autoriza',
        'fecha_ingreso'
    ];
}
