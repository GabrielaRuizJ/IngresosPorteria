<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;
    protected $table = 'socios';
    protected $fillable = [
        'cedula',
        'nombre',
        'accion',
        'email',
        'secuencia'
    ];
}
