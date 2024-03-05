<?php

namespace App\Http\Controllers;
use App\Models\Ingreso;
use App\Models\Tipo_Ingreso;
use App\Models\Tipo_Vehiculo;

use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index(){
        $ingresos = Tipo_ingreso::all();
        $vehiculos = Tipo_Vehiculo::all();
        return view('ingresos.ingreso',compact('ingresos','vehiculos'));
    }

    public function store(Request $request){

    }
}
