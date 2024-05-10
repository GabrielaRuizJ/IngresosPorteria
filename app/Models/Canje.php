<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    use HasFactory;
    protected $table = 'detalle_canje';
    protected $fillable = [
        'id_ingreso',
        'id_club',
        'cedula_canje',
        'nombre_club',
        'fecha_inicio_canje',
        'fecha_fin_canje'
    ];
}
