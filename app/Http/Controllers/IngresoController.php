<?php

namespace App\Http\Controllers;
use App\Models\Ingreso;
use App\Models\Tipo_Ingreso;
use App\Models\Tipo_Vehiculo;
use App\Models\Canje;
use App\Models\Autorizado;
use App\Models\DetalleCanje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class IngresoController extends Controller
{
    public function index(){
        $ingresos = Tipo_ingreso::all();
        $vehiculos = Tipo_Vehiculo::all();
        return view('ingresos.ingreso',compact('ingresos','vehiculos'));
    }
    public function consultarIngreso(){
        try {
            $url = env('URL_SERVER_API','http://localhost');
            
            $documento = '1000127738';
            $response = Http::get('http://localhost/prueba/api.php?documento='.$documento);
            /*$url = env('URL_SERVER_API','http://localhost');
            $response = Http::post('http://localhost/prueba/api.php', [
                'documento' => $documento,
            ]);*/
            $data = $response->json();
            return $data;
        } catch (\Exception $e) {
            return $e;
        }
        
    }
    public function store(Request $request){
        try {

            $url = env('URL_SERVER_API','http://localhost');

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

            $ingresos = Tipo_ingreso::findOrFail($tipoingreso);
            $tipo_ingreso = $ingresos->nombre_ingreso;
            $fecha = date("Y-m-d");

            if($tipo_ingreso == "Socios"){
                $data = json_encode("Socios");
            }else if($tipo_ingreso == "Invitados" ){

                $response = Http::get('http://localhost/prueba/apiInvitado.php?documento='.$cedula);
                $data1 = json_decode($response);
                $data = json_encode(array($data1->respuesta,$data1->datos));

            }else if($tipo_ingreso == "Autorizado" ){

                $consulta = DB::table('autorizado')
                ->where('cedula_autorizado',"=", $cedula)
                ->where('fecha_ingreso',"=", $fecha )
                ->where('estado',"=", 1 )
                ->get();
                $datos_respuesta=$consulta[0]->cedula_autoriza." - ".$consulta[0]->nombre_autorizado;
                $arraydat = array("respuesta"=>200,"datos"=>$datos_respuesta);
                $data = $arraydat;

            }else if($tipo_ingreso == "Canje" ){
                $consulta = DB::table('detalle_canje')
                ->where('cedula_canje',"=", $cedula)
                ->get();
                if($consulta){
                    $consulta2 = DB::table('detalle_canje')
                    ->where('cedula_canje',"=", $cedula)
                    ->where('fecha_inicio_canje',">=", $fecha)
                    ->where('fecha_fin_canje',"<=", $fecha)
                    ->get();
                    if($consulta2){
                        $datos_respuesta=array($consulta[0]->cedula_canje." - ".$consulta[0]->id_club);  
                        $datos_r = array("respuesta"=>200,"datos"=>$datos_respuesta);
                    }else{
                        $datos_respuesta=array("El rango de fechas del canje ya ha pasado");  
                        $datos_r = array("respuesta"=>300,"datos"=>$datos_respuesta);                         
                    }
                }else{
                    $datos_respuesta=array("No hay registro");  
                    $datos_r = array("respuesta"=>300,"datos"=>$datos_respuesta);
                }
                $data = json_encode($datos_r);
            }
            
            return $data;
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
            $url = env('URL_SERVER_API','http://localhost');
            $response = Http::get('http://localhost/prueba/apiCanje.php');
            $data = $response->json();
            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
