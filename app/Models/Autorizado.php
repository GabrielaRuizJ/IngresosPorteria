<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizado extends Model
{
    use HasFactory;
    protected $table = 'autorizado';
    protected $fillable = [
        'cedula_autorizado',
        'nombre_autorizado',
        'cedula_autoriza',
        'nombre_autoriza',
        'fecha_ingreso',
        'fecha_fin_ingreso',
        'id_usuario_update'
    ];
}
