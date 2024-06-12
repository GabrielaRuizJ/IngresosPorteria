<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Log;
use App\Models\Ingreso;
use App\Models\Autorizado;
use Illuminate\Http\Request;
use App\Models\BloqueoIngreso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AutorizadoController extends Controller
{
    public function index(){
        $autorizados = Autorizado::where('estado',true)->get();

        $userId = Auth::id();
        $userdat = User::where('id', $userId)->first();
        $cedulaId = $userdat->cedula;
        $nameId = $userdat->name;

        return view("autorizados.autorizado",compact('autorizados','userId','cedulaId','nameId'));
    }

    public function store(Request $request){

        $fechaIngreso = $request->input('fechaIngreso');
        $fechaFIngreso = $request->input('fechaFIngreso');
        $fechaActual = date("Y-m-d");

        $userDat = Auth::user();
        $userId = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");

        if($fechaIngreso < $fechaActual || $fechaFIngreso < $fechaIngreso){
            $request->session()->flash('errormensaje', 'Fechas incorrectas');
            return redirect()->route('autorizados');
        }else{
            
            $cedula_autorizado = $request->input('docautorizado');
            
            $buscar_bloqueo = BloqueoIngreso::where('cedula',$cedula_autorizado)
            ->where('estado',true)
            ->where('bloqueo_ingreso',true)
            ->get();

            if($buscar_bloqueo->count()>0){
                $request->session()->flash('errormensaje', 'Ha ocurrido un error. La persona tiene un bloqueo para autorizar su ingreso');
                return redirect()->route('autorizados');
            }else{
                
                $validar_autoriza = Autorizado::where('cedula_autorizado',$cedula_autorizado)
                ->where('fecha_ingreso',$fechaIngreso)
                ->where('estado',true)
                ->get();
    
                //if(!$validar_autoriza->isEmpty()){
                if($validar_autoriza->count() > 0){
                    $request->session()->flash('errormensaje', 'Ya hay una autorización en esta fecha para la persona ');
                    return redirect()->route('autorizados');
                }else{
                    $autorizado = Autorizado::create([
                        "cedula_autorizado"=>$cedula_autorizado,
                        "nombre_autorizado"=>$request->input('nomautorizado'),
                        "cedula_autoriza"=>$request->input('docautoriza'),
                        "nombre_autoriza"=>$request->input('nomautoriza'),
                        "fecha_ingreso"=>$fechaIngreso,
                        "fecha_fin_ingreso"=>$fechaFIngreso
                    ]);
            
                    if($autorizado){
                        $guardarLog = Log::create([
                            'fecha'   => $fechaLog,
                            'accion'  =>'Insert',
                            'tabla_accion' => 'Autorizado',
                            'id_usuario' => $userId,
                            'nombre_usuario' => $userName,
                            'comentarios'=>'Nuevo autorizado '.$cedula_autorizado.'. Fecha de ingreso: '.$fechaIngreso
                        ]);
                        $request->session()->flash('mensaje', 'Autorización creada correctamente');
                        return redirect()->route('autorizados');
                    } else {
                        $request->session()->flash('errormensaje', 'Ha ocurrido un error. Por favor informe a el administrador');
                        return redirect()->route('autorizados');
                    }
                    
                }
    
            }
            
        }


    }

    function delete(Request $request){

        $idAutorizado = $request->input('datIdAut');
        $fechaIngresoElim = $request->input('datFIAut');
        $fFinIngresoElim = $request->input('datFFIAut');

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");
        
        $userId = Auth::id();
        $fechaAct = date("Y-m-d");

        if($fechaIngresoElim < $fechaAct){
            $request->session()->flash('errormensaje', 'No se pueden eliminar autorizaciones con fecha de ingreso que ya ha pasado');
            return redirect()->route('autorizados');
        }else{

            $validaIngreso1 = Autorizado::where('id',"=", $idAutorizado)
                    ->where('estado', '=', true)
                    //->whereBetween('fecha_ingreso', [$fechaIngresoElim,$fFinIngresoElim])
                    ->get();
            if($validaIngreso1){
                //Si hay registro del autorizado
                $validaIngreso2 = Ingreso::where('cedula',"=", $validaIngreso1[0]['cedula_autorizado'])
                ->whereBetween('fecha_ingreso', [$fechaIngresoElim,$fFinIngresoElim])
                ->get();
                $validaCount = $validaIngreso2->count();

                if($validaCount>0){
                    //La persona está dentro del club
                    $request->session()->flash('errormensaje', 'Error eliminando autorización de ingreso. La persona ya está dentro del club o ya ingresó y salió');
                    return redirect()->route('autorizados');
                }else{
                    $autorizado = Autorizado::where('id',$idAutorizado)->update([
                        'estado' => false,
                        'id_usuario_update' => $userId
                    ]);
                    if($autorizado){
                        $guardarLog = Log::create([
                            'fecha'   => $fechaLog,
                            'accion'  =>'Update',
                            'tabla_accion' => 'Autorizado',
                            'id_usuario' => $userIdLog,
                            'nombre_usuario' => $userName,
                            'comentarios'=>'Eliminar autorizado ID #'.$idAutorizado
                        ]);
                        $request->session()->flash('mensaje', 'Autorización eliminada correctamente');
                        return redirect()->route('autorizados');
                    }else{
                        $request->session()->flash('errormensaje', 'Error eliminando autorización de ingreso. Por favor contáctese con el administrador del sistema');
                        return redirect()->route('autorizados');
                    }
                }
            }else{
                //No hay registro de autorizado
                $request->session()->flash('errormensaje', 'Error buscando autorización de ingreso. Por favor contáctese con el administrador del sistema');
                return redirect()->route('autorizados');
            }

        }

    }

}
