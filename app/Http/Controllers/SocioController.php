<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Socio;

class SocioController extends Controller
{
    public function index(){
        $datos = Socio::all();
        return view('socios.socios',['socios'=>$datos]);
    }

    public function store(){
        $response = Http::get('http://localhost/prueba/apiSyncSocios.php');
        $data1 = json_decode($response);
                    
        if($data1->respuesta == 200){
            $datos_api = $data1->datos;
            $contSocioUpdate = 0;
            $contSocioNew = 0;
            $cont = 0;
            $cedula_b = "";
            foreach($datos_api as $dat_socios ){
                $buscarSocio = Socio::where('cedula', $dat_socios->socio)
                ->update([
                    'nombre' =>  $dat_socios->nombre,
                    'accion' =>  $dat_socios->accion,
                    'email' =>  $dat_socios->email,
                    'secuencia' =>  $dat_socios->secuencia
                ]);
                if($buscarSocio){
                    $contSocioUpdate++;
                }else{
                    $crearSocio = Socio::create([
                        'cedula' =>  $dat_socios->socio,
                        'nombre' =>  $dat_socios->nombre,
                        'accion' =>  $dat_socios->accion,
                        'email' =>  $dat_socios->email,
                        'secuencia' =>  $dat_socios->secuencia
                    ]);
                    if($crearSocio){
                        $contSocioNew++;
                    }
                   
                }
                $cont++;
            }
            if($cont)
            $datos_respuesta = "<h4>Resultado de la sincronizacion</h4>";
            $datos_respuesta .="<label>Total de socios recibidos en el servicio: </label>".$cont;
            $datos_respuesta .="<label>Total de socios actualizados: </label>".$contSocioUpdate;
            $datos_respuesta .="<label>Total de socios nuevos registrados: </label>".$contSocioNew;

            session()->flash('mensaje',$datos_respuesta);
            return redirect()->route('socios');
        }else{
            $data = json_encode(array($data1->datos));
            session()->flash('mensaje',json_encode($data));
            return redirect()->route('socios');
        }
    }

}
