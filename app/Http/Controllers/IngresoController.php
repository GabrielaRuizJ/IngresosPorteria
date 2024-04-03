<?php

namespace App\Http\Controllers;
use App\Models\Ingreso;
use App\Models\Tipo_Ingreso;
use App\Models\Tipo_Vehiculo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

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

    }
}
