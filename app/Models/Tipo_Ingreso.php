<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Ingreso extends Model
{
    use HasFactory;
    protected $table = "tipo_ingreso";
    protected $fillable = [
        'nombre_ingreso'
    ];
}
