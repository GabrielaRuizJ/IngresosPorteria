<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCanje extends Model
{
    protected $table="detalle_canje";
    use HasFactory;
    protected $fillable = [
        'id_ingreso',
        'id_club',
        'nombre_club',
        'fecha_incio_canje',
        'fecha_fin_canje'
    ];
}
