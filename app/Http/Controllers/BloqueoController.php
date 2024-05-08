<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloqueo;
use Illuminate\Support\Facades\DB;

class BloqueoController extends Controller
{
    public function index(){
        $datos = Bloqueo::all();
        return view('socios.bloqueos',['bloqueos'=>$datos]);
    }

    public function store(Request $request){
        $bloqueo = Bloqueo::create([
            'nombre_bloqueo'=>$request->input('nombrebloqueo')
        ]);

        if($bloqueo){
            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
            return redirect()->route('bloqueos');
        } else {
            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuniquese con el administrador del sistema');
            return redirect()->route('bloqueos');
        }
    }

}
