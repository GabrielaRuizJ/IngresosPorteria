<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    protected $table="invitados";
    use HasFactory;
    protected $fillable = [
        'doc_anfitrion',
	    'nombre_anfitrion',
	    'doc_invitado',
	    'nombre_invitado',
	    'fecha_ingreso'
    ];
}
