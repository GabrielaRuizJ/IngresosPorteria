<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class SalidaController extends Controller
{
    public function store(Request $request){
        $userId = Auth::id();
        
        $salidaIndv = Ingreso::where('estado', true)
            ->where('id',$request->input('dat1salidaINDV'))
            ->update([
                'estado' => false,
                'id_usuario_update' => $userId
        ]);

        if($salidaIndv){
            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
            return redirect()->route('salidas');
        } else {
            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuniquese con el administrador del sistema');
            return redirect()->route('salidas');
        }
    }

}
