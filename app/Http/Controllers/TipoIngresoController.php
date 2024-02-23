<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_ingreso;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TipoIngresoController extends Controller
{
    public function index(){
        $tipoingresos = Tipo_ingreso::all();
        return view('parametros.tipoIngreso',compact('tipoingresos'));
    }
    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'nombre_ingreso' => 'required|unique:tipo_ingreso,nombre_ingreso'
            ]);
            if($validator->fails()){
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }else{
                $request->session()->flash('mensaje', 'Tipo de ingreso creado correctamente');
                $tipoingreso = Tipo_Ingreso::create(['nombre_ingreso'=>$request->input('nombre_ingreso')]);
                return redirect()->route('tipo_ingreso');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }
}
