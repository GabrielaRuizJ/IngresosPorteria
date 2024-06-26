<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model
{
    use HasFactory;
    protected $table = 'bloqueo';
    protected $fillable = [
        'nombre_bloqueo',
        'estado',
        'id_usuario_create',
        'id_usuario_update'
    ];
}
