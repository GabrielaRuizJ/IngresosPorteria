<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index(){
        $logs = Log::all();
        return view("log.log",compact('logs'));
    }

    public function find(Request $request){
        $fecha_inicioB = $request->input('fechainiciobusqueda');
        $fecha_finB = $request->input('fechafinbusqueda');
        
        if($fecha_inicioB && $fecha_finB){
            if($fecha_inicioB > $fecha_finB){
                $request->session()->flash('errormensaje', 'La fecha de inicio de búsqueda no puede ser mayor a la fecha fin de la búsqueda');
                return redirect()->route('log');
            }else{
                $logs = Log::whereBetween('fecha',[$fecha_inicioB, $fecha_finB])->get();
                //$logs = DB::table('log')->whereBetween('fecha', [$fecha_inicioB, $fecha_finB])->get();
                //dd($logs);
                if($logs){
                    return view("log.logResultados",compact('logs'));
                }else{
                    $request->session()->flash('errormensaje', 'Error realizando búsqueda. Contacte al administrador del sistema');
                    return redirect()->route('log');
                }
            }
        }else{
            $request->session()->flash('errormensaje', 'Las fechas son obligatorias para la búsqueda');
            return redirect()->route('log');
        }

    }
}
