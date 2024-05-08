<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloqueoSocio;
use App\Models\Bloqueo;
use App\Models\Socio;
use Illuminate\Support\Facades\DB;

class BloqueoSocioController extends Controller
{
    public function index(){

        $datos = DB::table('bloqueo_socio')
        ->join('bloqueo','bloqueo_socio.tipo_bloqueo','=','bloqueo.id')
        ->select('bloqueo_socio.id as id','bloqueo_socio.cedula as cedula','bloqueo_socio.accion as accion',
        'bloqueo.nombre_bloqueo as tipo_bloqueo','bloqueo_socio.fecha_inicio_bloqueo as fecha_inicio_bloqueo',
        'bloqueo_socio.fecha_fin_bloqueo as fecha_fin_bloqueo','bloqueo_socio.indefinido as indefinido',
        'bloqueo_socio.bloqueo_consumo as bloqueo_consumo','bloqueo_socio.bloqueo_ingreso as bloqueo_ingreso')
        ->get();
        $socios = Socio::all();
        return view('socios.bloqueoSocio',['bloqueo_socio'=>$datos,'socios'=>$socios]);
    }

    public function store(Request $request){
        /*$bloqueo = Bloqueo::create([
            'nombre_bloqueo'=>$request->input('nombrebloqueo')
        ]);

        if($bloqueo){
            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
            return redirect()->route('bloqueos');
        } else {
            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuniquese con el administrador del sistema');
            return redirect()->route('bloqueos');
        }*/
    }
}
