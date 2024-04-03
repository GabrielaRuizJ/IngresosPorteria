<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table="ingreso";
    use HasFactory;
    protected $fillable = [
        'fecha_ingreso',
        'hora_ingreso',
        'id_tipo_vehiculo',
        'id_tipo_ingreso',
        'cedula',
        'nombre',
        'estado',
        'fecha_salida',
        'hora_salida',
        'id_usuario_create'
    ];
}
