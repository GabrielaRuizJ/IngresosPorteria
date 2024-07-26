<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Log;
use DateTime;
use App\Models\User;
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

            $userDat = User::find($userId);
            $userIdLog = $userDat->id;
            $userName = $userDat->name;
            $fechaLog = date("Y-m-d H:i:s");
                $busqueda = Ingreso::find($request->input('dat1salidaINDV'));

                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Update',
                    'tabla_accion' => 'Ingreso',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Salida del sistema id '.$busqueda->id.' cedula #'.$busqueda->cedula
                ]);
            $request->session()->flash('mensaje', 'Salida realizada correctamente');
            return redirect()->route('salidas');
        } else {
            $request->session()->flash('errormensaje', 'Error al realizar salida. Por favor comuniquese con el administrador del sistema');
            return redirect()->route('salidas');
        }
    }

}
