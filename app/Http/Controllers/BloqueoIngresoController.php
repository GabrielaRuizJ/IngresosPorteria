<?php

namespace App\Http\Controllers;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\BloqueoIngreso;
use App\Models\Bloqueo;
use App\Models\Socio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BloqueoIngresoController extends Controller
{
    public function index(){

        $datos = DB::table('bloqueo_ingreso')
        ->join('bloqueo','bloqueo_ingreso.tipo_bloqueo','=','bloqueo.id')
        ->select('bloqueo_ingreso.id as id','bloqueo_ingreso.estado as estado','bloqueo_ingreso.cedula as cedula',
        'bloqueo.nombre_bloqueo as tipo_bloqueo','bloqueo_ingreso.fecha_inicio_bloqueo as fecha_inicio_bloqueo',
        'bloqueo_ingreso.fecha_fin_bloqueo as fecha_fin_bloqueo','bloqueo_ingreso.indefinido as indefinido',
        'bloqueo_ingreso.bloqueo_consumo as bloqueo_consumo','bloqueo_ingreso.bloqueo_ingreso as bloqueo_ingreso')
        ->get();
        $bloqueos = Bloqueo::all();
        return view('parametros.bloqueoIngreso',['bloqueo_ingreso'=>$datos,'bloqueos'=>$bloqueos]);
    }

    public function store(Request $request){

        $listado_bloqueos = $request->input('listado_bloqueos');
        $cedulaBloqueo = $request->input('cedulaBloqueo');
        $bloqueoTodosAccion = $request->input('bloqueoTodosAccion');

        $bloqueo_ingresoP = $request->input('bloqueo_ingreso');
        if($bloqueo_ingresoP){
            $bloqueo_ingresoP = true;
        }else{
            $bloqueo_ingresoP = false;
        }

        $bloqueo_consumo = $request->input('bloqueo_consumo');
        if($bloqueo_consumo){
            $bloqueo_consumo = true;
        }else{
            $bloqueo_consumo = false;
        }

        $bloqueo_indf = $request->input('bloqueo_indf');
        if($bloqueo_indf){
            $bloqueo_indf = true;
        }else{
            $bloqueo_indf = false;
        }

        $fecInicioBloqueo = $request->input('fecInicioBloqueo');
        $fecFinBloqueo = $request->input('fecFinBloqueo');

        $userId = Auth::id();
        $factual = date("Y-m-d");

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");

        if($listado_bloqueos && $cedulaBloqueo){
            if($bloqueo_indf){
                // Es bloqueo indefinido
                //validar si ya hay un bloqueo para esa persona
                    $buscar_bloqueo = BloqueoIngreso::where('cedula',$cedulaBloqueo)
                    ->where('estado',true)
                    ->orderByDesc('id')
                    //->first()
                    ->get();

                    if($buscar_bloqueo->count()>0){
                        $request->session()->flash('errormensaje', 'Error al crear bloqueo. La persona ya tiene un bloqueo registrado en el sistema');
                        return redirect()->route('bloqueo_ingreso');
                    }else{
                        //No hay bloqueo para esa persona
                        $bloqueo_ingreso_Persona = BloqueoIngreso::create([
                            'cedula'=>$cedulaBloqueo,
                            'tipo_bloqueo'=>$listado_bloqueos,
                            'estado'=>true,
                            'indefinido'=>true,
                            'bloqueo_consumo'=>$bloqueo_consumo,
                            'bloqueo_ingreso'=>$bloqueo_ingresoP,
                            'id_usuario_create'=>$userId
                        ]);
                        // Si se hizo el registro correctamente
                        if($bloqueo_ingreso_Persona){
                            $guardarLog = Log::create([
                                'fecha'   => $fechaLog,
                                'accion'  =>'Insert',
                                'tabla_accion' => 'Bloqueo para ingreso',
                                'id_usuario' => $userIdLog,
                                'nombre_usuario' => $userName,
                                'comentarios'=>'Bloquear ingreso documento #'.$cedulaBloqueo
                            ]);
                            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
                            return redirect()->route('bloqueo_ingreso');
                        }else{
                            // Si NO se hizo el registro correctamente
                            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuníquese con el administrador del sistema');
                            return redirect()->route('bloqueo_ingreso');
                        }
                    }
            }else{
                //No es bloqueo indefinido
                if(($fecFinBloqueo < $fecInicioBloqueo) || ($fecInicioBloqueo < $factual) ){
                    $request->session()->flash('errormensaje', 'Fechas incorrectas');
                    return redirect()->route('bloqueo_ingreso');
                }else{

                    $buscar_bloqueo = BloqueoIngreso::where('cedula',$cedulaBloqueo)
                    ->where('estado',true)
                    ->orderByDesc('id')
                    //->first();
                    ->get();

                    if($buscar_bloqueo->count()>0){
                        $request->session()->flash('errormensaje', 'Error al crear bloqueo. La persona ya tiene un bloqueo registrado en el sistema');
                        return redirect()->route('bloqueo_ingreso');
                    }else{
                        $bloqueo_ingreso_Persona = BloqueoIngreso::create([
                            'cedula'=>$cedulaBloqueo,
                            'tipo_bloqueo'=>$listado_bloqueos,
                            'estado'=>true,
                            'indefinido'=>false,
                            'fecha_inicio_bloqueo'=>$fecInicioBloqueo,
                            'fecha_fin_bloqueo'=>$fecFinBloqueo,
                            'bloqueo_consumo'=>$bloqueo_consumo,
                            'bloqueo_ingreso'=>$bloqueo_ingresoP,
                            'id_usuario_create'=>$userId
                        ]);
        
                        // Si se hizo el registro correctamente
                        if($bloqueo_ingreso_Persona){
                            $guardarLog = Log::create([
                                'fecha'   => $fechaLog,
                                'accion'  =>'Insert',
                                'tabla_accion' => 'Bloqueo para ingreso',
                                'id_usuario' => $userIdLog,
                                'nombre_usuario' => $userName,
                                'comentarios'=>'Bloquear ingreso documento #'.$cedulaBloqueo
                            ]);
                            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
                            return redirect()->route('bloqueo_ingreso');
                        }else{
                            // Si NO se hizo el registro correctamente
                            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuníquese con el administrador del sistema');
                            return redirect()->route('bloqueo_ingreso');
                            //dd('error 3');
                        }
                    }
                    
                }
            }
        }else{
            // No hay tipo de bloqueo ni numero de cedula
            $request->session()->flash('errormensaje', 'El tipo de bloqueo y la cedula son datos obligatorios para el registro');
            return redirect()->route('bloqueo_ingreso');
            /*if($listado_bloqueos ){
                dd('error 001 '.$listado_bloqueos." - ".$cedulaBloqueo);
            }else{
                dd('error 01 '.$listado_bloqueos." - ".$cedulaBloqueo);
            }*/
        }
    }

    function delete(Request $request){
        $id_bloqueo = $request->input('datIdBloq');
        $userId = Auth::id();

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");

        if($id_bloqueo){
            $datBloqueo = BloqueoIngreso::where('id',$id_bloqueo)
            ->get();
            if($datBloqueo->count()>0){
                $updateBloqueo = BloqueoIngreso::where('id',$id_bloqueo)->update([
                    'estado' => false,
                    'id_usuario_update' => $userId
                ]);
                if($updateBloqueo){
                    $guardarLog = Log::create([
                        'fecha'   => $fechaLog,
                        'accion'  =>'Update',
                        'tabla_accion' => 'Bloqueo para ingreso',
                        'id_usuario' => $userIdLog,
                        'nombre_usuario' => $userName,
                        'comentarios'=>'Desactivar bloqueo ID #'.$id_bloqueo
                    ]);
                    $request->session()->flash('mensaje', 'Bloqueo desactivado correctamente');
                    return redirect()->route('bloqueo_ingreso');
                }else{
                    $request->session()->flash('errormensaje', 'Error desactivando bloqueo. Por favor comuníquese con el administrador del sistema');
                    return redirect()->route('bloqueo_ingreso');
                }
            }else{
                $request->session()->flash('errormensaje', 'No se encontraron datos del bloqueo');
                return redirect()->route('bloqueo_ingreso');
            }
        }else{
            $request->session()->flash('errormensaje', 'No se recibió id del bloqueo');
            return redirect()->route('bloqueo_ingreso');
        }
    }
}
