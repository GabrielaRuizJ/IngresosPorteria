<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloqueo;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BloqueoController extends Controller
{
    public function index(){
        $datos = Bloqueo::all();
        return view('socios.bloqueos',['bloqueos'=>$datos]);
    }

    public function store(Request $request){

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");


        $userId = Auth::id();
        $nom_bloqueo = $request->input('nombrebloqueo');

        if($nom_bloqueo){
            $bloqueo = Bloqueo::create([
                'nombre_bloqueo'=>$nom_bloqueo,
                'estado'=>true,
                'id_usuario_create'=>$userId
            ]);
            if($bloqueo){
                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Insert',
                    'tabla_accion' => 'Bloqueo',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Nuevo bloqueo: '.$nom_bloqueo
                ]);

                $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
                return redirect()->route('bloqueos');
            } else {
                $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuniquese con el administrador del sistema');
                return redirect()->route('bloqueos');
            }
        }else{
            $request->session()->flash('errormensaje', 'El campo nombre del bloqueo es obligatorio');
            return redirect()->route('bloqueos');
        }

    }
    public function delete(Request $request){

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");

        $userId = Auth::id();
        $id_bloqueo = $request->input('datIdBloq');

        if($id_bloqueo){

            $estadoAct = Bloqueo::where('id',$id_bloqueo)->get();
            if($estadoAct[0]->estado){
                $bloqueo = Bloqueo::where('id',$id_bloqueo)->update([
                    'estado'=>false,
                    'id_usuario_update'=>$userId
                ]);
                if($bloqueo){
                    $guardarLog = Log::create([
                        'fecha'   => $fechaLog,
                        'accion'  =>'Update',
                        'tabla_accion' => 'Bloqueo',
                        'id_usuario' => $userIdLog,
                        'nombre_usuario' => $userName,
                        'comentarios'=>'Desactivar bloqueo ID #'.$id_bloqueo
                    ]);
                    $request->session()->flash('mensaje', 'Bloqueo desactivado correctamente');
                    return redirect()->route('bloqueos');
                } else {
                    $request->session()->flash('errormensaje', 'Error al desactivar bloqueo. Por favor comuníquese con el administrador del sistema');
                    return redirect()->route('bloqueos');
                }
            }else{
                $bloqueo = Bloqueo::where('id',$id_bloqueo)->update([
                    'estado'=>true,
                    'id_usuario_update'=>$userId
                ]);
                if($bloqueo){
                    $guardarLog = Log::create([
                        'fecha'   => $fechaLog,
                        'accion'  =>'Update',
                        'tabla_accion' => 'Bloqueo',
                        'id_usuario' => $userIdLog,
                        'nombre_usuario' => $userName,
                        'comentarios'=>'Activar bloqueo ID #'.$id_bloqueo
                    ]);
                    $request->session()->flash('mensaje', 'Bloqueo activado correctamente');
                    return redirect()->route('bloqueos');
                } else {
                    $request->session()->flash('errormensaje', 'Error al activando bloqueo. Por favor comuníquese con el administrador del sistema');
                    return redirect()->route('bloqueos');
                }
            }
        }else{
            $request->session()->flash('errormensaje', 'No se recibió id del bloqueo. Por favor comuníquese con el administrador del sistema');
            return redirect()->route('bloqueos');
        }
    }

}
