<?php

namespace App\Http\Controllers;
use App\Models\Ingreso;
use App\Models\TipoIngreso;
use App\Models\TipoVehiculo;
use App\Models\Canje;
use App\Models\Club;
use App\Models\Autorizado;
use App\Models\Socio;
use App\Models\Invitado;
use App\Models\BloqueoIngreso;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class IngresoController extends Controller
{
    public function index(){
        $ingresos = TipoIngreso::all();
        $vehiculos = TipoVehiculo::all();
        $userId = Auth::id();
        return view('ingresos.ingreso',compact('ingresos','vehiculos','userId'));
    }

    public function ingresosHoy(){
        $fecha = date("Y-m-d");
        $veringresosHoy = DB::table('ingreso')
        ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
        ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
        ->select('ingreso.id as id','ingreso.hora_ingreso as hora_ingreso','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo',
        'tipo_ingreso.nombre_ingreso as nombre_ingreso','ingreso.placa as placa','ingreso.cedula as cedula','ingreso.nombre as nombre')
        ->where('ingreso.fecha_ingreso',"=", $fecha)
        ->where('ingreso.estado', '=', true)
        ->get();

        $ingresos = TipoIngreso::all();
        return view('ingresos.salida',compact('veringresosHoy','ingresos'));
    }

    public function salidaMSV(Request $request){

        $tiposalida = $request->input('tiposalidaTodos');
        $userId = Auth::id();

        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");

        if($tiposalida){

            $fecha = date("Y-m-d");
            $salidaMasiva = Ingreso::where('fecha_ingreso', $fecha)
            ->where('estado', true)
            ->update([
                'estado' => false,
                'id_usuario_update' => $userId
            ]);

            if ($salidaMasiva > 0) {
                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Insert',
                    'tabla_accion' => 'Ingreso',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Salida masiva de personas del sistema'
                ]);
                
                $request->session()->flash('mensaje', 'Salida masiva realizada correctamente');
                return redirect()->route('salidas');
            } else {
                $request->session()->flash('errormensaje', 'Error al realizar salida masiva. Por favor comuniquese con el administrador del sistema');
                return redirect()->route('salidas');
            }

        }else{
            $fecha = date("Y-m-d");
            
            $tipossalida =  $request->input('tiposalida',[]);
            
            if (!is_array($tipossalida)) { $tipossalida = [$tipossalida]; }
            
            $salidaIndv = Ingreso::where('fecha_ingreso', $fecha)
            ->whereIn('id_tipo_ingreso', $tipossalida)
            ->update([
                'estado' => false,
                'id_usuario_update' => $userId
            ]);

            if ($salidaIndv > 0) {
                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Update',
                    'tabla_accion' => 'Ingreso',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Salida masiva x tipos de ingreso '.$tipossalida
                ]);
                $request->session()->flash('mensaje', 'Salida masiva realizada correctamente');
                return redirect()->route('salidas');
            } else {
                $request->session()->flash('errormensaje', 'No hay datos para ejecutar esta accion.');
                return redirect()->route('salidas');
            }

        }
        //return
    }
    //Pagina de busqueda de ingresos
    public function busquedaIngresos(){

        $tipo_ingresos = TipoIngreso::all();
        $tipo_vehiculos = TipoVehiculo::all();
        
        return view('ingresos.listadoIngresos',compact('tipo_ingresos','tipo_vehiculos'));
    }
    //Resultados de busqueda de ingresos
    public function resultadoBusquedaIngresos(Request $request){

        $fecha_inicio  = $request ->input('fechainiciobusqueda');
        $fecha_fin     = $request ->input('fechafinbusqueda');

        $tipo_ingreso  = $request ->input('tiposalidaTodos');
        $tipo_vehiculo = $request ->input('tiposvehiculosTodos');

        $tipos_ingresos = $request->input('tiposalida',[]);
        // Convertir a array si no lo es
        if (!is_array($tipos_ingresos)) { $tipos_ingresos = [$tipos_ingresos]; }
       
        $tipos_vehiculo = $request->input('tipovehiculo',[]);
        // Convertir a array si no lo es 
        if (!is_array($tipos_vehiculo)) { $tipos_vehiculo = [$tipos_vehiculo]; }

        if($fecha_inicio > $fecha_fin){
            $request->session()->flash('errormensaje', 'La fecha inicial de la búsqueda no puede ser mayor a al fecha final de la búsqueda');
            return redirect()->route('listadoIngresos');
        }else{
            if($fecha_inicio && $fecha_fin && $tipos_ingresos && !$tipos_vehiculo){
                //Si hay rango de fechas y tipo de ingresos
                $busqueda = DB::table('ingreso')
                ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
                ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
                ->select('ingreso.id as id','ingreso.cedula as cedula','ingreso.fecha_ingreso','ingreso.hora_ingreso as hora_ingreso','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo',
                'tipo_ingreso.nombre_ingreso as nombre_ingreso','ingreso.placa as placa','ingreso.nombre as nombre')
                ->whereBetween('ingreso.fecha_ingreso',[$fecha_inicio, $fecha_fin])
                ->whereIn('ingreso.id_tipo_ingreso', $tipos_ingresos)
                //;
                ->get();
                //dd($busqueda);
                //dd("Aca 1 ".$tipos_ingresos);
                $busquedaIngresos = DB::table('tipo_ingreso')
                    ->select('tipo_ingreso.id as id','tipo_ingreso.nombre_ingreso as nombre_ingreso')
                    ->whereIn('tipo_ingreso.id', $tipos_ingresos)
                    ->get();
                $restipobusqueda = 1;
    
                return view('ingresos.resultadosBusqueda',compact('restipobusqueda','busqueda','fecha_inicio','fecha_fin','busquedaIngresos'));
                
            }
    
            //Si hay rango de fechas y tipo de vehiculos
            if($fecha_inicio && $fecha_fin && $tipos_vehiculo && !$tipos_ingresos){
    
                $busqueda = DB::table('ingreso')
                ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
                ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
                ->select('ingreso.id as id','ingreso.fecha_ingreso as fecha','ingreso.hora_ingreso as hora_ingreso','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo',
                'tipo_ingreso.nombre_ingreso as nombre_ingreso','ingreso.placa as placa','ingreso.cedula as cedula','ingreso.nombre as nombre')
                ->whereBetween('ingreso.fecha_ingreso',[$fecha_inicio, $fecha_fin])
                ->whereIn('ingreso.id_tipo_vehiculo', $tipos_vehiculo)
                //;
                ->get();
    
                $busquedaVehiculos= DB::table('tipo_vehiculo')
                ->select('tipo_vehiculo.id as id','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo')
                ->whereIn('tipo_vehiculo.id', $tipos_vehiculo)
                ->get();
    
                //dd($busqueda);
                //dd("Aca 2 ".$tipos_vehiculo);
                $restipobusqueda = 2;
                return view('ingresos.resultadosBusqueda',compact('restipobusqueda','busqueda','fecha_inicio','fecha_fin','busquedaVehiculos'));
            }
    
            //Si hay rango de fechas, tipo de ingreso y tipo de vehiculos
            if($fecha_inicio && $fecha_fin && $tipos_ingresos && $tipos_vehiculo){
    
                $busqueda = DB::table('ingreso')
                ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
                ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
                ->select('ingreso.id as id','ingreso.fecha_ingreso as fecha','ingreso.hora_ingreso as hora_ingreso','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo',
                'tipo_ingreso.nombre_ingreso as nombre_ingreso','ingreso.placa as placa','ingreso.cedula as cedula','ingreso.nombre as nombre')
                ->whereBetween('ingreso.fecha_ingreso',[$fecha_inicio, $fecha_fin])
                ->whereIn('ingreso.id_tipo_ingreso', $tipos_ingresos)
                ->whereIn('ingreso.id_tipo_vehiculo', $tipos_vehiculo)
                
                ->get();
                //dd($busqueda);
                //dd("Aca 3 ".$tipos_ingresos." - ".$tipos_vehiculo);
                $busquedaIngresos = DB::table('tipo_ingreso')
                ->select('tipo_ingreso.id as id','tipo_ingreso.nombre_ingreso as nombre_ingreso')
                ->whereIn('tipo_ingreso.id', $tipos_ingresos)
                ->get();
                
                $busquedaVehiculos= DB::table('tipo_vehiculo')
                ->select('tipo_vehiculo.id as id','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo')
                ->whereIn('tipo_vehiculo.id', $tipos_vehiculo)
                ->get();
                
                $restipobusqueda = 3;
                return view('ingresos.resultadosBusqueda',compact('restipobusqueda','busqueda','fecha_inicio','fecha_fin','busquedaIngresos','busquedaVehiculos'));
    
            }
    
            //Si hay rango de fechas pero no tipos de ingreso ni vehiculo
            //Busca todos los ingresos en el rango de fechas con todos los tipos de vehiculos e ingresos
            if($fecha_inicio && $fecha_fin && !$tipos_ingresos && !$tipos_vehiculo){
                    
                $busqueda = DB::table('ingreso')
                ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
                ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
                ->select('ingreso.id as id','ingreso.fecha_ingreso as fecha','ingreso.hora_ingreso as hora_ingreso','tipo_vehiculo.nombre_vehiculo as nombre_vehiculo',
                'tipo_ingreso.nombre_ingreso as nombre_ingreso','ingreso.placa as placa','ingreso.cedula as cedula','ingreso.nombre as nombre')
                ->whereBetween('ingreso.fecha_ingreso',[$fecha_inicio, $fecha_fin])
                //;
                ->get();
                //dd($busqueda);
                $restipobusqueda = 4;
                return view('ingresos.resultadosBusqueda',compact('restipobusqueda','busqueda','fecha_inicio','fecha_fin'));
            }
        }    
    }

    public function store(Request $request){
        try {

            $cedulaIngreso = $request->input('cedula');

            $validaIngreso = DB::table('ingreso')
                    ->where('cedula',"=", $cedulaIngreso)
                    ->where('estado', '=', true)
                    ->get();

            if( $validaIngreso->isNotEmpty() ){

                $datos_respuesta = "La persona ya se encuentra dentro del club ";
                $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                return $data;

            }else{


                $tipovehiculo = $request->input('tipov');
                $placa = $request->input('placa');
                $tipoingreso = $request->input('tipoi');
                $cedula = $request->input('cedula');
                $primerApellido = $request->input('primAp');
                $segundoApellido = $request->input('segAp');
                $primerNombre = $request->input('primNm');
                $segundoNombre = $request->input('segNm');
                $datOculto1 = $request->input('dtOct1');
                $datOculto2 = $request->input('dtOct2');
                $userId = $request->input('iduserlog');
    
                $nombre_persona = $primerApellido." ".$segundoApellido." ".$primerNombre." ".$segundoNombre;
                $ingresos = TipoIngreso::findOrFail($tipoingreso);
                $tipo_ingreso = $ingresos->nombre_ingreso;
                $fecha = date("Y-m-d");

                $userDat = User::find($userId);
                $userIdLog = $userDat->id;
                $userName = $userDat->name;
                $fechaLog = date("Y-m-d H:i:s");

                $buscarBloqueoP = BloqueoIngreso::where('cedula',$cedula)
                ->where('estado',true)
                ->orderByDesc('id','desc')
                ->first();
            if($buscarBloqueoP){
                //Hay un bloqueo
                $tipoBloqPersona1 = $buscarBloqueoP->indefinido;
                $tipoBloqPersona2 = $buscarBloqueoP->bloqueo_ingreso;
                if($tipoBloqPersona1 && $tipoBloqPersona2 ){
                    //Tiene bloqueo indefinido y bloqueo de ingreso
                    $datos_r = array("respuesta"=>300,"datos"=>"La persona esta bloqueada indefinidamente para ingresar");
                    $data = json_encode($datos_r);
                    return $data;
                }else if($tipoBloqPersona2){
                    //Tiene bloqueo de ingreso
                    $tipoBloqPersona3 = $buscarBloqueoP->fecha_inicio_bloqueo;
                    $tipoBloqPersona4 = $buscarBloqueoP->fecha_fin_bloqueo;
                    if( ($fecha>= $tipoBloqPersona3 ) && ($fecha<= $tipoBloqPersona4) ){
                        //Todavia esta bloqueado
                        $datos_r = array("respuesta"=>300,"datos"=>"La persona esta bloqueada para ingresar hasta el día ".$tipoBloqPersona4);
                        $data = json_encode($datos_r);
                        return $data;
                    }else{
                        //Ya no está bloqueado
                        if($tipo_ingreso == "Socio"){
    
                            $consulta = Socio::where('cedula',"=", $cedula)
                            ->get();
                            $arraydat = array();
            
                            if($consulta->count() > 0){
            
                                    $fechaIngreso = date("Y-m-d");
                                    $hora_Ingreso = date("H:m:s");
            
                                    //if(!$nombre_persona){
                                        $nombre_persona = $consulta[0]->nombre;
                                    //}
            
                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
            
                                    if($crearIngreso){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso socio documento #'.$cedula
                                        ]);
                                        $datos_respuesta = "Correcto ";
                                        $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                    }else{
                                        $datos_respuesta = "Error insertando datos: ";
                                        $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                    }
                                
                            }else{
                                $datos_respuesta = "No hay registro del socio";
                                $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
            
                            $data = $arraydat;

                        }else if($tipo_ingreso == "Invitado" ){
            
                            $fechaIngreso = date("Y-m-d");
                            $hora_Ingreso = date("H:m:s");
            
                            $primerDiaM = new datetime('first day of this month'); 
                            $primerDiaM = $primerDiaM->format('Y-m-d');
            
                            $ultimoDiaM = new datetime('last day of this month'); 
                            $ultimoDiaM = $ultimoDiaM->format('Y-m-d');
            
                            $primerDiaA = new datetime('first day of January'); 
                            $primerDiaA = $primerDiaA->format('Y-m-d');
            
                            $ultimoDiaA = new datetime('last day of December'); 
                            $ultimoDiaA = $ultimoDiaA->format('Y-m-d');
                            //dd($primerDiaM." - ".$ultimoDiaM." - ".$primerDiaA." - ".$ultimoDiaA);
                            $response = Invitado::where('doc_invitado',$cedula)
                                ->where('fecha_ingreso',$fechaIngreso)
                                ->get();
            
                            if($response){
                                //Buscar ingresos del invitado x mes
                                $contadorInvitadoMes = Ingreso::where('cedula', $cedula)
                                ->where('id_tipo_ingreso',2)
                                ->whereBetween('fecha_ingreso', [$primerDiaM, $ultimoDiaM])
                                ->count();
                                $contadorInvitadoYear = Ingreso::where('cedula', $cedula)
                                ->where('id_tipo_ingreso',2)
                                ->whereBetween('fecha_ingreso', [$primerDiaA, $ultimoDiaA])
                                ->count();
            
                                if(($contadorInvitadoMes >= 2) || ($contadorInvitadoYear>=24)){
                                    //Ya ingresó dos veces al mes o 24 en el año
                                    if($contadorInvitadoMes >= 2){
                                        $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 2 veces en el mes ";
                                    }else{
                                        $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 24 veces en el año ";
                                    }
                                    $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                }else{
                                    //No ha ingresado dos veces al mes o 24 en el año
                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
                                    if($crearIngreso){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso invitado documento #'.$cedula
                                        ]);
                                        $datos_respuesta = "Ingreso de invitado reistrado correctamente";
                                        $data = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                    }else{
                                        $datos_respuesta = "Error insertando invitado";
                                        $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                    }
                                }
                            }else{
                                $datos_respuesta = "No hay registro de invitado";
                                $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
            
                        }else if($tipo_ingreso == "Autorizado" ){
            
                            $consulta = DB::table('autorizado')
                            ->where('cedula_autorizado',"=", $cedula)
                            ->where('fecha_ingreso',"=", $fecha )
                            ->where('estado',"=", 1 )
                            ->get();
            
                            if($consulta->count() > 0){
                                
                                $fechaIngreso = date("Y-m-d");
                                $hora_Ingreso = date("H:m:s");
                                $crearIngreso = Ingreso::create([
                                    'fecha_ingreso'=>$fechaIngreso,
                                    'hora_ingreso'=>$hora_Ingreso,
                                    'id_tipo_vehiculo'=>$tipovehiculo,
                                    'id_tipo_ingreso'=>$tipoingreso,
                                    'placa'=>$placa, 
                                    'cedula'=>$cedula,
                                    'nombre'=>$nombre_persona,
                                    'id_usuario_create'=>$userId
                                ]);
                                if($crearIngreso){
                                    $guardarLog = Log::create([
                                        'fecha'   => $fechaLog,
                                        'accion'  =>'Insert',
                                        'tabla_accion' => 'Ingreso',
                                        'id_usuario' => $userIdLog,
                                        'nombre_usuario' => $userName,
                                        'comentarios'=>'Ingreso autorizado documento #'.$cedula
                                    ]);
                                    $datos_respuesta = "Canje registrado correctamente";
                                    $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                }else{
                                    $datos_respuesta = "Error insertando autorizado";
                                    $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                }
                                
                            }else{
                                $datos_respuesta = "No existe registro para autorizar ingreso";
                                $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
            
                            $data = $arraydat;
                        }else if($tipo_ingreso == "Canje" ){
                            $idclub = $request->input('idclubcanje');
                            $finiciocanje = $request->input('finiciocanje');
                            $ffincanje = $request->input('ffincanje');
                            
                            $datos_r=array($idclub,$finiciocanje,$ffincanje);  
                            $data = array("respuesta"=>300,"datos"=>$datos_r);
                            if( ($idclub) && ($finiciocanje) && ($ffincanje)){
            
                                $fechaIngreso = date("Y-m-d");
                                $hora_Ingreso = date("H:m:s");
            
                                if($finiciocanje > $ffincanje){
            
                                    $datos_r=array("Rango de fechas incorrecto ");  
                                    $data = array("respuesta"=>300,"datos"=>$datos_r);
            
                                }else{
                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
                                    $nuevoIngresoId = $crearIngreso->id;
                                    $nombre_club = Club::find($idclub);
                                    $nombre_club = $nombre_club->club;
                                    $detalle_canje = Canje::create([
                                        'id_ingreso'=>$nuevoIngresoId,
                                        'id_club'=>$idclub,
                                        'cedula_canje'=>$cedula,
                                        'nombre_club'=>$nombre_club,
                                        'fecha_inicio_canje'=>$finiciocanje,
                                        'fecha_fin_canje'=>$ffincanje
                                    ]);
            
                                    if($crearIngreso && $detalle_canje){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso canje documento #'.$cedula
                                        ]);
                                        $datos_r=array("Canje registrado correctamente");  
                                        $data = array("respuesta"=>200,"datos"=>$datos_r);
                                    }else{
                                        $datos_r=array("Error guardando registro de canje ");  
                                        $data = array("respuesta"=>300,"datos"=>$datos_r);
                                    }
                                }
            
                            }else{
            
                                //No hay datos, validar si el canje tiene rango disponible 
                                $consulta2 = DB::table('detalle_canje')
                                ->where('cedula_canje',"=", $cedula)
                                ->orderByDesc('id')
                                ->first(); 
                                if($consulta2){
            
                                    if( $fecha >= $consulta2->fecha_inicio_canje && $fecha <= $consulta2->fecha_fin_canje ){
                                        $idclub = $request->input('idclubcanje');
                                        $fechaIngreso = date("Y-m-d");
                                        $hora_Ingreso = date("H:m:s");
                
                                        $crearIngreso = Ingreso::create([
                                            'fecha_ingreso'=>$fechaIngreso,
                                            'hora_ingreso'=>$hora_Ingreso,
                                            'id_tipo_vehiculo'=>$tipovehiculo,
                                            'id_tipo_ingreso'=>$tipoingreso,
                                            'placa'=>$placa, 
                                            'cedula'=>$cedula,
                                            'nombre'=>$nombre_persona,
                                            'id_usuario_create'=>$userId
                                        ]);
                                        $nuevoIngresoId = $crearIngreso->id;
                
                                        $detalle_canje = Canje::create([
                                            'id_ingreso'=>$nuevoIngresoId,
                                            'id_club'=>$consulta2->id_club,
                                            'cedula_canje'=>$cedula,
                                            'nombre_club'=>$consulta2->nombre_club,
                                            'fecha_inicio_canje'=>$consulta2->fecha_inicio_canje,
                                            'fecha_fin_canje'=>$consulta2->fecha_fin_canje
                                        ]);
                
                                        if($crearIngreso && $detalle_canje){
                                            $guardarLog = Log::create([
                                                'fecha'   => $fechaLog,
                                                'accion'  =>'Insert',
                                                'tabla_accion' => 'Ingreso',
                                                'id_usuario' => $userIdLog,
                                                'nombre_usuario' => $userName,
                                                'comentarios'=>'Ingreso canje documento #'.$cedula
                                            ]);
                                            $datos_r=array("Canje registrado correctamente");  
                                            $data = array("respuesta"=>200,"datos"=>$datos_r);
                                        }else{
                                            $datos_r=array("Error guardando registro de canje ");  
                                            $data = array("respuesta"=>300,"datos"=>$datos_r);
                                        }
                
                                    }else{
                                        $datos_r=array("Rango de fechas vencido");  
                                        $data = array("respuesta"=>301,"datos"=>$datos_r); 
                                    }
            
                                }else{
                                    
                                    $datos_r = array("No hay registro de canje");  
                                    $data = array("respuesta"=>404,"datos"=>$datos_r); 
            
                                }
                                
                            }
                            
                        }else{
            
                            $datos_r = array("respuesta"=>300,"datos"=>"No existe el tipo de ingreso");
                            $data = json_encode($datos_r);
            
                        }
                        
                        return $data;
                    }

                }else if(!$tipoBloqPersona2){
                    //No tiene bloqueo de ingreso
                    if($tipo_ingreso == "Socio"){
    
                        $consulta = Socio::where('cedula',"=", $cedula)
                        ->get();
                            $arraydat = array();
            
                            if($consulta->count() > 0){
            
                                    $fechaIngreso = date("Y-m-d");
                                    $hora_Ingreso = date("H:m:s");
            
                                    //if(!$nombre_persona){
                                        $nombre_persona = $consulta[0]->nombre;
                                    //}

                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
            
                                    if($crearIngreso){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso socio documento #'.$cedula
                                        ]);
                                        $datos_respuesta = "Correcto ";
                                        $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                    }else{
                                        $datos_respuesta = "Error insertando datos: ";
                                        $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                    }
                                
                            }else{
                                $datos_respuesta = "No hay registro del socio";
                                $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
            
                            $data = $arraydat;
                    }else if($tipo_ingreso == "Invitado" ){
        
                        $fechaIngreso = date("Y-m-d");
                        $hora_Ingreso = date("H:m:s");
        
                        $primerDiaM = new datetime('first day of this month'); 
                        $primerDiaM = $primerDiaM->format('Y-m-d');
        
                        $ultimoDiaM = new datetime('last day of this month'); 
                        $ultimoDiaM = $ultimoDiaM->format('Y-m-d');
        
                        $primerDiaA = new datetime('first day of January'); 
                        $primerDiaA = $primerDiaA->format('Y-m-d');
        
                        $ultimoDiaA = new datetime('last day of December'); 
                        $ultimoDiaA = $ultimoDiaA->format('Y-m-d');
                        //dd($primerDiaM." - ".$ultimoDiaM." - ".$primerDiaA." - ".$ultimoDiaA);
                        $response = Invitado::where('doc_invitado',$cedula)
                            ->where('fecha_ingreso',$fechaIngreso)
                            ->get();
        
                        if($response){
                            //Buscar ingresos del invitado x mes
                            $contadorInvitadoMes = Ingreso::where('cedula', $cedula)
                            ->where('id_tipo_ingreso',2)
                            ->whereBetween('fecha_ingreso', [$primerDiaM, $ultimoDiaM])
                            ->count();
                            $contadorInvitadoYear = Ingreso::where('cedula', $cedula)
                            ->where('id_tipo_ingreso',2)
                            ->whereBetween('fecha_ingreso', [$primerDiaA, $ultimoDiaA])
                            ->count();
        
                            if(($contadorInvitadoMes >= 2) || ($contadorInvitadoYear>=24)){
                                //Ya ingresó dos veces al mes o 24 en el año
                                if($contadorInvitadoMes >= 2){
                                    $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 2 veces en el mes ";
                                }else{
                                    $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 24 veces en el año ";
                                }
                                $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }else{
                                //No ha ingresado dos veces al mes o 24 en el año
                                $crearIngreso = Ingreso::create([
                                    'fecha_ingreso'=>$fechaIngreso,
                                    'hora_ingreso'=>$hora_Ingreso,
                                    'id_tipo_vehiculo'=>$tipovehiculo,
                                    'id_tipo_ingreso'=>$tipoingreso,
                                    'placa'=>$placa, 
                                    'cedula'=>$cedula,
                                    'nombre'=>$nombre_persona,
                                    'id_usuario_create'=>$userId
                                ]);
                                if($crearIngreso){
                                    $guardarLog = Log::create([
                                        'fecha'   => $fechaLog,
                                        'accion'  =>'Insert',
                                        'tabla_accion' => 'Ingreso',
                                        'id_usuario' => $userIdLog,
                                        'nombre_usuario' => $userName,
                                        'comentarios'=>'Ingreso invitado documento #'.$cedula
                                    ]);
                                    $datos_respuesta = "Ingreso de invitado reistrado correctamente";
                                    $data = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                }else{
                                    $datos_respuesta = "Error insertando invitado";
                                    $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                }
                            }
                        }else{
                            $datos_respuesta = "No hay registro de invitado";
                            $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                        }
        
                    }else if($tipo_ingreso == "Autorizado" ){
        
                        $consulta = DB::table('autorizado')
                        ->where('cedula_autorizado',"=", $cedula)
                        ->where('fecha_ingreso',"=", $fecha )
                        ->where('estado',"=", 1 )
                        ->get();
        
                        if($consulta->count() > 0){
                            
                            $fechaIngreso = date("Y-m-d");
                            $hora_Ingreso = date("H:m:s");
                            $crearIngreso = Ingreso::create([
                                'fecha_ingreso'=>$fechaIngreso,
                                'hora_ingreso'=>$hora_Ingreso,
                                'id_tipo_vehiculo'=>$tipovehiculo,
                                'id_tipo_ingreso'=>$tipoingreso,
                                'placa'=>$placa, 
                                'cedula'=>$cedula,
                                'nombre'=>$nombre_persona,
                                'id_usuario_create'=>$userId
                            ]);
                            if($crearIngreso){
                                $guardarLog = Log::create([
                                    'fecha'   => $fechaLog,
                                    'accion'  =>'Insert',
                                    'tabla_accion' => 'Ingreso',
                                    'id_usuario' => $userIdLog,
                                    'nombre_usuario' => $userName,
                                    'comentarios'=>'Ingreso autorizado documento #'.$cedula
                                ]);
                                $datos_respuesta = "Canje registrado correctamente";
                                $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                            }else{
                                $datos_respuesta = "Error insertando autorizado";
                                $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
                            
                        }else{
                            $datos_respuesta = "No existe registro para autorizar ingreso";
                            $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                        }
        
                        $data = $arraydat;
                    }else if($tipo_ingreso == "Canje" ){
                        $idclub = $request->input('idclubcanje');
                        $finiciocanje = $request->input('finiciocanje');
                        $ffincanje = $request->input('ffincanje');
                        
                        $datos_r=array($idclub,$finiciocanje,$ffincanje);  
                        $data = array("respuesta"=>300,"datos"=>$datos_r);
                        if( ($idclub) && ($finiciocanje) && ($ffincanje)){
        
                            $fechaIngreso = date("Y-m-d");
                            $hora_Ingreso = date("H:m:s");
        
                            if($finiciocanje > $ffincanje){
        
                                $datos_r=array("Rango de fechas incorrecto ");  
                                $data = array("respuesta"=>300,"datos"=>$datos_r);
        
                            }else{
                                $crearIngreso = Ingreso::create([
                                    'fecha_ingreso'=>$fechaIngreso,
                                    'hora_ingreso'=>$hora_Ingreso,
                                    'id_tipo_vehiculo'=>$tipovehiculo,
                                    'id_tipo_ingreso'=>$tipoingreso,
                                    'placa'=>$placa, 
                                    'cedula'=>$cedula,
                                    'nombre'=>$nombre_persona,
                                    'id_usuario_create'=>$userId
                                ]);
                                $nuevoIngresoId = $crearIngreso->id;
                                $nombre_club = Club::find($idclub);
                                $nombre_club = $nombre_club->club;
                                $detalle_canje = Canje::create([
                                    'id_ingreso'=>$nuevoIngresoId,
                                    'id_club'=>$idclub,
                                    'cedula_canje'=>$cedula,
                                    'nombre_club'=>$nombre_club,
                                    'fecha_inicio_canje'=>$finiciocanje,
                                    'fecha_fin_canje'=>$ffincanje
                                ]);
        
                                if($crearIngreso && $detalle_canje){
                                    $guardarLog = Log::create([
                                        'fecha'   => $fechaLog,
                                        'accion'  =>'Insert',
                                        'tabla_accion' => 'Ingreso',
                                        'id_usuario' => $userIdLog,
                                        'nombre_usuario' => $userName,
                                        'comentarios'=>'Ingreso canje documento #'.$cedula
                                    ]);
                                    $datos_r=array("Canje registrado correctamente");  
                                    $data = array("respuesta"=>200,"datos"=>$datos_r);
                                }else{
                                    $datos_r=array("Error guardando registro de canje ");  
                                    $data = array("respuesta"=>300,"datos"=>$datos_r);
                                }
                            }
        
                        }else{
        
                            //No hay datos, validar si el canje tiene rango disponible 
                            $consulta2 = DB::table('detalle_canje')
                            ->where('cedula_canje',"=", $cedula)
                            ->orderByDesc('id')
                            ->first(); 
                            if($consulta2){
        
                                if( $fecha >= $consulta2->fecha_inicio_canje && $fecha <= $consulta2->fecha_fin_canje ){
                                    $idclub = $request->input('idclubcanje');
                                    $fechaIngreso = date("Y-m-d");
                                    $hora_Ingreso = date("H:m:s");
            
                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
                                    $nuevoIngresoId = $crearIngreso->id;
            
                                    $detalle_canje = Canje::create([
                                        'id_ingreso'=>$nuevoIngresoId,
                                        'id_club'=>$consulta2->id_club,
                                        'cedula_canje'=>$cedula,
                                        'nombre_club'=>$consulta2->nombre_club,
                                        'fecha_inicio_canje'=>$consulta2->fecha_inicio_canje,
                                        'fecha_fin_canje'=>$consulta2->fecha_fin_canje
                                    ]);
            
                                    if($crearIngreso && $detalle_canje){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso canje documento #'.$cedula
                                        ]);
                                        $datos_r=array("Canje registrado correctamente");  
                                        $data = array("respuesta"=>200,"datos"=>$datos_r);
                                    }else{
                                        $datos_r=array("Error guardando registro de canje ");  
                                        $data = array("respuesta"=>300,"datos"=>$datos_r);
                                    }
            
                                }else{
                                    $datos_r=array("Rango de fechas vencido");  
                                    $data = array("respuesta"=>301,"datos"=>$datos_r); 
                                }
        
                            }else{
                                
                                $datos_r = array("No hay registro de canje");  
                                $data = array("respuesta"=>404,"datos"=>$datos_r); 
        
                            }
                            
                        }
                        
                    }else{
        
                        $datos_r = array("respuesta"=>300,"datos"=>"No existe el tipo de ingreso");
                        $data = json_encode($datos_r);
        
                    }
                    
                    return $data;
                }

            }else{                
                if($tipo_ingreso == "Socio"){
    
                        $consulta = Socio::where('cedula',"=", $cedula)
                            ->get();
                            $arraydat = array();
            
                            if($consulta->count() > 0){
            
                                    $fechaIngreso = date("Y-m-d");
                                    $hora_Ingreso = date("H:m:s");
            
                                    //if(!$nombre_persona){
                                        $nombre_persona = $consulta[0]->nombre;
                                    //}
            
                                    $crearIngreso = Ingreso::create([
                                        'fecha_ingreso'=>$fechaIngreso,
                                        'hora_ingreso'=>$hora_Ingreso,
                                        'id_tipo_vehiculo'=>$tipovehiculo,
                                        'id_tipo_ingreso'=>$tipoingreso,
                                        'placa'=>$placa, 
                                        'cedula'=>$cedula,
                                        'nombre'=>$nombre_persona,
                                        'id_usuario_create'=>$userId
                                    ]);
            
                                    if($crearIngreso){
                                        $guardarLog = Log::create([
                                            'fecha'   => $fechaLog,
                                            'accion'  =>'Insert',
                                            'tabla_accion' => 'Ingreso',
                                            'id_usuario' => $userIdLog,
                                            'nombre_usuario' => $userName,
                                            'comentarios'=>'Ingreso socio documento #'.$cedula
                                        ]);
                                        $datos_respuesta = "Correcto ";
                                        $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                                    }else{
                                        $datos_respuesta = "Error insertando datos: ";
                                        $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                                    }
                                
                            }else{
                                $datos_respuesta = "No hay registro del socio";
                                $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
            
                            $data = $arraydat;
                }else if($tipo_ingreso == "Invitado" ){
    
                    $fechaIngreso = date("Y-m-d");
                    $hora_Ingreso = date("H:m:s");
    
                    $primerDiaM = new datetime('first day of this month'); 
                    $primerDiaM = $primerDiaM->format('Y-m-d');
    
                    $ultimoDiaM = new datetime('last day of this month'); 
                    $ultimoDiaM = $ultimoDiaM->format('Y-m-d');
    
                    $primerDiaA = new datetime('first day of January'); 
                    $primerDiaA = $primerDiaA->format('Y-m-d');
    
                    $ultimoDiaA = new datetime('last day of December'); 
                    $ultimoDiaA = $ultimoDiaA->format('Y-m-d');
                    //dd($primerDiaM." - ".$ultimoDiaM." - ".$primerDiaA." - ".$ultimoDiaA);
                    $response = Invitado::where('doc_invitado',$cedula)
                        ->where('fecha_ingreso',$fechaIngreso)
                        ->get();
    
                    if($response){
                        //Buscar ingresos del invitado x mes
                        $contadorInvitadoMes = Ingreso::where('cedula', $cedula)
                        ->where('id_tipo_ingreso',2)
                        ->whereBetween('fecha_ingreso', [$primerDiaM, $ultimoDiaM])
                        ->count();
                        $contadorInvitadoYear = Ingreso::where('cedula', $cedula)
                        ->where('id_tipo_ingreso',2)
                        ->whereBetween('fecha_ingreso', [$primerDiaA, $ultimoDiaA])
                        ->count();
    
                        if(($contadorInvitadoMes >= 2) || ($contadorInvitadoYear>=24)){
                            //Ya ingresó dos veces al mes o 24 en el año
                            if($contadorInvitadoMes >= 2){
                                $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 2 veces en el mes ";
                            }else{
                                $datos_respuesta = "Error insertando invitado. La persona ya ha ingresado 24 veces en el año ";
                            }
                            $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                        }else{
                            //No ha ingresado dos veces al mes o 24 en el año
                            $crearIngreso = Ingreso::create([
                                'fecha_ingreso'=>$fechaIngreso,
                                'hora_ingreso'=>$hora_Ingreso,
                                'id_tipo_vehiculo'=>$tipovehiculo,
                                'id_tipo_ingreso'=>$tipoingreso,
                                'placa'=>$placa, 
                                'cedula'=>$cedula,
                                'nombre'=>$nombre_persona,
                                'id_usuario_create'=>$userId
                            ]);
                            if($crearIngreso){
                                $guardarLog = Log::create([
                                    'fecha'   => $fechaLog,
                                    'accion'  =>'Insert',
                                    'tabla_accion' => 'Ingreso',
                                    'id_usuario' => $userIdLog,
                                    'nombre_usuario' => $userName,
                                    'comentarios'=>'Ingreso invitado documento #'.$cedula
                                ]);
                                $datos_respuesta = "Ingreso de invitado reistrado correctamente";
                                $data = array("respuesta"=>200,"datos"=>$datos_respuesta);
                            }else{
                                $datos_respuesta = "Error insertando invitado";
                                $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                            }
                        }
                    }else{
                        $datos_respuesta = "No hay registro de invitado";
                        $data = array("respuesta"=>300,"datos"=>$datos_respuesta);
                    }
    
                }else if($tipo_ingreso == "Autorizado" ){
    
                    $consulta = DB::table('autorizado')
                    ->where('cedula_autorizado',"=", $cedula)
                    ->where('fecha_ingreso',"=", $fecha )
                    ->where('estado',"=", 1 )
                    ->get();
    
                    if($consulta->count() > 0){
                        
                        $fechaIngreso = date("Y-m-d");
                        $hora_Ingreso = date("H:m:s");
                        $crearIngreso = Ingreso::create([
                            'fecha_ingreso'=>$fechaIngreso,
                            'hora_ingreso'=>$hora_Ingreso,
                            'id_tipo_vehiculo'=>$tipovehiculo,
                            'id_tipo_ingreso'=>$tipoingreso,
                            'placa'=>$placa, 
                            'cedula'=>$cedula,
                            'nombre'=>$nombre_persona,
                            'id_usuario_create'=>$userId
                        ]);
                        if($crearIngreso){
                            $guardarLog = Log::create([
                                'fecha'   => $fechaLog,
                                'accion'  =>'Insert',
                                'tabla_accion' => 'Ingreso',
                                'id_usuario' => $userIdLog,
                                'nombre_usuario' => $userName,
                                'comentarios'=>'Ingreso autorizado documento #'.$cedula
                            ]);
                            $datos_respuesta = "Canje registrado correctamente";
                            $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                        }else{
                            $datos_respuesta = "Error insertando autorizado";
                            $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                        }
                        
                    }else{
                        $datos_respuesta = "No existe registro para autorizar ingreso";
                        $arraydat = array("respuesta"=>300,"datos"=>$datos_respuesta);
                    }
    
                    $data = $arraydat;
                }else if($tipo_ingreso == "Canje" ){
                    $idclub = $request->input('idclubcanje');
                    $finiciocanje = $request->input('finiciocanje');
                    $ffincanje = $request->input('ffincanje');
                    
                    $datos_r=array($idclub,$finiciocanje,$ffincanje);  
                    $data = array("respuesta"=>300,"datos"=>$datos_r);
                    if( ($idclub) && ($finiciocanje) && ($ffincanje)){
    
                        $fechaIngreso = date("Y-m-d");
                        $hora_Ingreso = date("H:m:s");
    
                        if($finiciocanje > $ffincanje){
    
                            $datos_r=array("Rango de fechas incorrecto ");  
                            $data = array("respuesta"=>300,"datos"=>$datos_r);
    
                        }else{
                            $crearIngreso = Ingreso::create([
                                'fecha_ingreso'=>$fechaIngreso,
                                'hora_ingreso'=>$hora_Ingreso,
                                'id_tipo_vehiculo'=>$tipovehiculo,
                                'id_tipo_ingreso'=>$tipoingreso,
                                'placa'=>$placa, 
                                'cedula'=>$cedula,
                                'nombre'=>$nombre_persona,
                                'id_usuario_create'=>$userId
                            ]);
                            $nuevoIngresoId = $crearIngreso->id;
                            $nombre_club = Club::find($idclub);
                            $nombre_club = $nombre_club->club;
                            $detalle_canje = Canje::create([
                                'id_ingreso'=>$nuevoIngresoId,
                                'id_club'=>$idclub,
                                'cedula_canje'=>$cedula,
                                'nombre_club'=>$nombre_club,
                                'fecha_inicio_canje'=>$finiciocanje,
                                'fecha_fin_canje'=>$ffincanje
                            ]);
    
                            if($crearIngreso && $detalle_canje){
                                $guardarLog = Log::create([
                                    'fecha'   => $fechaLog,
                                    'accion'  =>'Insert',
                                    'tabla_accion' => 'Ingreso',
                                    'id_usuario' => $userIdLog,
                                    'nombre_usuario' => $userName,
                                    'comentarios'=>'Ingreso canje documento #'.$cedula
                                ]);
                                $datos_r=array("Canje registrado correctamente");  
                                $data = array("respuesta"=>200,"datos"=>$datos_r);
                            }else{
                                $datos_r=array("Error guardando registro de canje ");  
                                $data = array("respuesta"=>300,"datos"=>$datos_r);
                            }
                        }
    
                    }else{
    
                        //No hay datos, validar si el canje tiene rango disponible 
                        $consulta2 = DB::table('detalle_canje')
                        ->where('cedula_canje',"=", $cedula)
                        ->orderByDesc('id')
                        ->first(); 
                        if($consulta2){
    
                            if( $fecha >= $consulta2->fecha_inicio_canje && $fecha <= $consulta2->fecha_fin_canje ){
                                $idclub = $request->input('idclubcanje');
                                $fechaIngreso = date("Y-m-d");
                                $hora_Ingreso = date("H:m:s");
        
                                $crearIngreso = Ingreso::create([
                                    'fecha_ingreso'=>$fechaIngreso,
                                    'hora_ingreso'=>$hora_Ingreso,
                                    'id_tipo_vehiculo'=>$tipovehiculo,
                                    'id_tipo_ingreso'=>$tipoingreso,
                                    'placa'=>$placa, 
                                    'cedula'=>$cedula,
                                    'nombre'=>$nombre_persona,
                                    'id_usuario_create'=>$userId
                                ]);
                                $nuevoIngresoId = $crearIngreso->id;
        
                                $detalle_canje = Canje::create([
                                    'id_ingreso'=>$nuevoIngresoId,
                                    'id_club'=>$consulta2->id_club,
                                    'cedula_canje'=>$cedula,
                                    'nombre_club'=>$consulta2->nombre_club,
                                    'fecha_inicio_canje'=>$consulta2->fecha_inicio_canje,
                                    'fecha_fin_canje'=>$consulta2->fecha_fin_canje
                                ]);
        
                                if($crearIngreso && $detalle_canje){
                                    $guardarLog = Log::create([
                                        'fecha'   => $fechaLog,
                                        'accion'  =>'Insert',
                                        'tabla_accion' => 'Ingreso',
                                        'id_usuario' => $userIdLog,
                                        'nombre_usuario' => $userName,
                                        'comentarios'=>'Ingreso canje documento #'.$cedula
                                    ]);
                                    $datos_r=array("Canje registrado correctamente");  
                                    $data = array("respuesta"=>200,"datos"=>$datos_r);
                                }else{
                                    $datos_r=array("Error guardando registro de canje ");  
                                    $data = array("respuesta"=>300,"datos"=>$datos_r);
                                }
        
                            }else{
                                $datos_r=array("Rango de fechas vencido");  
                                $data = array("respuesta"=>301,"datos"=>$datos_r); 
                            }
    
                        }else{
                            
                            $datos_r = array("No hay registro de canje");  
                            $data = array("respuesta"=>404,"datos"=>$datos_r); 
    
                        }
                        
                    }
                    
                }else{
    
                    $datos_r = array("respuesta"=>300,"datos"=>"No existe el tipo de ingreso");
                    $data = json_encode($datos_r);
    
                }
                
                return $data;
            }
        }

        } catch (\Exception $e) {
            return $e;
        }
    }


    public function select(){
        $ingresos = DB::table('ingreso')
        ->join('tipo_ingreso','ingreso.id_tipo_ingreso','=','tipo_ingreso.id')
        ->join('tipo_vehiculo','ingreso.id_tipo_vehiculo','=','tipo_vehiculo.id')
        ->join('users as user_create','ingreso.id_usuario_create','=','user_create.id')
        ->join('users as user_update','ingreso.id_usuario_update','=','user_update.id')
        ->select('ingreso.fecha_ingreso','ingreso.hora_ingreso','tipo_vehiculo.nombre_vehiculo',
        'tipo_ingreso.nombre_ingreso','ingreso.cedula','ingreso.nombre','ingreso.estado',
        'ingreso.fecha_salida','ingreso.hora_salida')
        ->where('fecha_ingreso','=',Carbon::now()->toDateString())
        ->get();

        return view('ingresos.salida',compact('ingresos'));
    }

    public function consultaCanje(){
        try {
            $clubes = Club::all();
            if($clubes){
                $line = array();
                foreach ($clubes as $consultar){
                    $dato = array("id_club"=>$consultar['id'],"club"=>$consultar['club']);
                    array_push($line,$dato);
                }
                $retornar = json_encode(array("respuesta"=>"200","datos"=>$line));
            }else{
                $retornar = json_encode($clubes);
            }
            return $retornar;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
