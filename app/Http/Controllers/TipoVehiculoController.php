<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_vehiculo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class TipoVehiculoController extends Controller
{
    public function index(){
        $tipovehiculos = Tipo_vehiculo::all();
        return view('parametros.tipoVehiculo',compact('tipovehiculos'));
    }
    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'nombre_vehiculo' => 'required|unique:tipo_vehiculo,nombre_vehiculo'
            ]);
            if($validator->fails()){
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }else{
                $tipoingreso = Tipo_vehiculo::create(['nombre_vehiculo'=>$request->input('nombre_vehiculo')]);
                $request->session()->flash('mensaje', 'Tipo de vehiculo creado correctamente');
                return redirect()->route('tipo_vehiculo');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

}
