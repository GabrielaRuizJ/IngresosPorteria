<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table="log";
    use HasFactory;
    protected $fillable = [
        'fecha',
        'accion',
        'tabla_accion',
        'id_usuario',
        'nombre_usuario',
        'comentarios'
    ];
}
