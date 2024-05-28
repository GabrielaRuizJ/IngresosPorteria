<?php

namespace App\Http\Controllers;
use App\Models\Autorizado;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AutorizadoController extends Controller
{
    public function index(){
        $autorizados = Autorizado::all();
        return view("autorizados.autorizado",compact('autorizados'));
    }

    public function store(Request $request){

        $fechaIngreso = $request->input('fechaIngreso');
        $fechaActual = date("Y-m-d");

        if($fechaIngreso < $fechaActual){
            $request->session()->flash('errormensaje', 'Fecha de ingreso incorrecta');
            return redirect()->route('autorizados');
        }else{
            $cedula_autorizado = $request->input('docautorizado');
            $validar_autoriza = Autorizado::where('cedula_autorizado',$cedula_autorizado)
            ->where('fecha_ingreso',$fechaIngreso)
            ->get();

            //if(!$validar_autoriza->isEmpty()){
            if($validar_autoriza->count() > 0){
                //dd("D1 lleno".$validar_autoriza);
                $request->session()->flash('errormensaje', 'Ya hay una autorización en esta fecha para la persona ');
                return redirect()->route('autorizados');
            }else{
                //dd("D2 vacio".$validar_autoriza);
                $autorizado = Autorizado::create([
                    "cedula_autorizado"=>$cedula_autorizado,
                    "nombre_autorizado"=>$request->input('nomautorizado'),
                    "cedula_autoriza"=>$request->input('docautoriza'),
                    "nombre_autoriza"=>$request->input('nomautoriza'),
                    "fecha_ingreso"=>$fechaIngreso
                ]);
        
                if($autorizado){
                    $request->session()->flash('mensaje', 'Autorización creada correctamente'.$fechaIngreso);
                    return redirect()->route('autorizados');
                } else {
                    $request->session()->flash('errormensaje', 'Ha ocurrido un error. Por favor informe a el administrador');
                    return redirect()->route('autorizados');
                }
                
            }

        }

    }

    function delete(Request $request){
        $idAutorizado = $request->input('datIdAut');
        $fechaIngresoElim = $request->input('datFIAut');
        $fechaAct = date("Y-m-d");
        if($fechaIngresoElim<$fechaAct){
            $request->session()->flash('errormensaje', 'No se pueden eliminar autorizaciones con fecha de ingreso que ya ha pasado');
            return redirect()->route('autorizados');
        }else{
            $autorizado=Autorizado::where('id',$idAutorizado)->delete();
            if($autorizado){
                $request->session()->flash('mensaje', 'Autorización eliminaada correctamente');
                return redirect()->route('autorizados');
            }else{
                $request->session()->flash('errormensaje', 'Error eliminando autorización de ingreso. Por favor contáctese');
                return redirect()->route('autorizados');
            }
            
        }

    }

}
