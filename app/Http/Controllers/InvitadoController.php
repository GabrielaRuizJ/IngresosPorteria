<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;
use Illuminate\Support\Facades\DB;

class InvitadoController extends Controller
{
    public function index(){
        $invitados = Invitado::all();
        return view("invitados.invitado",compact('invitados'));
    }

}
