<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueoSocio extends Model
{
    use HasFactory;
    protected $table = 'bloqueo_socio';
    protected $fillable = [
        'cedula',
        'accion',
        'tipo_bloqueo',
        'fecha_inicio_bloqueo',
        'fecha_inicio_bloqueo',
        'fecha_fin_bloqueo',
        'indefinido',
        'bloqueo_consumo',
        'bloqueo_ingreso'
    ];
}
