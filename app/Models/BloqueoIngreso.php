<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueoIngreso extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'bloqueo_ingreso';
    protected $fillable = [
        'cedula',
        'tipo_bloqueo',
        'estado',
        'indefinido',
        'bloqueo_consumo',
        'bloqueo_ingreso',
        'id_usuario_create',
        'id_usuario_update',
        'fecha_inicio_bloqueo',
        'fecha_fin_bloqueo',
    ];
	
}
