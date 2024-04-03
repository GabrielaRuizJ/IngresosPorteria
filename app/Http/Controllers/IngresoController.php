<?php

namespace App\Http\Controllers;
use App\Models\Ingreso;
use App\Models\Tipo_Ingreso;
use App\Models\Tipo_Vehiculo;
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
        try{
            $validator = Validator::make($request->all(),[
                'tipov'=>'required',
                'placa'=>'required',
            ]);

            if($validator->fails()){
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }else{
                $idUsuario = Auth::id();
                $contador = 0;
                for($i=1;$i<=$request->input('cantidadocp');$i++){
                    $contador++;
                    $ingreso = Ingreso::create([
                        'fecha_ingreso'=>Carbon::now()->toDateString(),
                        'hora_ingreso'=>Carbon::now()->toTimeString(),
                        'id_tipo_vehiculo'=>$request->input('tipov'),
                        'id_tipo_ingreso'=>$request->input('tipoingresoacompa'.$i),
                        'cedula'=>$request->input('cedulaacompa'.$i),
                        'nombre'=>$request->input('nombreacompa'.$i),
                        'id_usuario_create'=>$idUsuario
                    ]);
                }
                if($request->input('cantidadocp') == $contador ){
                    $request->session()->flash('mensaje', 'Ingreso registrado correctamente');
                }else{
                    $request->session()->flash('mensaje', 'Se registraron '.$contador.' de '.$request->input('cantidadocp').' registros recibidos');
                }                  
                return redirect()->route('ingresos');
            }
        }catch(\Exception $e){
            dd($e->getMessage());
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
}
