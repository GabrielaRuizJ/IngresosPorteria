<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table="clubes_canje";
    use HasFactory;
    protected $fillable = [
        'id',
        'club',
        'pbx',
        'correo',
        'estado'
    ];
}
