<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoVehiculo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;


class TipoVehiculoController extends Controller
{
    public function index(){
        $tipovehiculos = TipoVehiculo::all();
        return view('parametros.tipoVehiculo',compact('tipovehiculos'));
    }
    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'nombre_vehiculo' => 'required|unique:tipo_vehiculo,nombre_vehiculo'
            ]);
            
            $userDat = Auth::user();
            $userIdLog = $userDat->id;
            $userName = $userDat->name;
            $fechaLog = date("Y-m-d H:i:s");

            if($validator->fails()){
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }else{
                $tipoingreso = TipoVehiculo::create(['nombre_vehiculo'=>$request->input('nombre_vehiculo')]);
                $vehLog = $request->input('nombre_vehiculo');
                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Insert',
                    'tabla_accion' => 'Tipo de vehiculo',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Agregar tipo de vehiculo '.$vehLog
                ]);

                $request->session()->flash('mensaje', 'Tipo de vehiculo creado correctamente');
                return redirect()->route('tipo_vehiculo');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

}
