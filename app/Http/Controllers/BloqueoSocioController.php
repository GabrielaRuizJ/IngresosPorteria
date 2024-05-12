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
        $socios = Socio::select('cedula','nombre','accion')->get();
        $bloqueos = Bloqueo::all();
        return view('socios.bloqueoSocio',['bloqueo_socio'=>$datos,'socios'=>$socios,'bloqueos'=>$bloqueos]);
    }

    public function store(Request $request){

        $listado_bloqueos = $request->input('listado_bloqueos');
        $accionBloqueo = $request->input('accionBloqueo');
        $cedulaBloqueo = $request->input('cedulaBloqueo');
        $bloqueoTodosAccion = $request->input('bloqueoTodosAccion');

        $bloqueo_ingreso = $request->input('bloqueo_ingreso');
        if($bloqueo_ingreso){
            $bloqueo_ingreso = true;
        }else{
            $bloqueo_ingreso = false;
        }

        $bloqueo_consumo = $request->input('bloqueo_consumo');
        if($bloqueo_consumo){
            $bloqueo_consumo = true;
        }else{
            $bloqueo_consumo = false;
        }

        $bloqueo_indf = $request->input('bloqueo_indf');
        if($bloqueo_indf){
            $bloqueo_indf = true;
        }else{
            $bloqueo_indf = false;
        }

        $fecInicioBloqueo = $request->input('fecInicioBloqueo');
        $fecFinBloqueo = $request->input('fecFinBloqueo');

        if($listado_bloqueos && $accionBloqueo ){
            if($bloqueoTodosAccion){
                //Se bloquea todos los beneficiarios del derecho
                $contador = 0;
                if($bloqueo_indf){
                    // Es bloqueo indefinido x todo el nucleo
                        $buscar_beneficiarios = Socio::select('cedula','accion')->where('accion','=',$accionBloqueo)->get();
                        if($buscar_beneficiarios){
                            //recorrer array de socios si se encontraron datos
                            foreach ($buscar_beneficiarios as $socio) {
                                $bloqueo_socio = BloqueoSocio::create([
                                    'cedula'=>$socio->cedula,
                                    'accion'=>$accionBloqueo,
                                    'tipo_bloqueo'=>$listado_bloqueos,
                                    'fecha_inicio_bloqueo'=>$fecInicioBloqueo,
                                    'fecha_fin_bloqueo'=>$fecFinBloqueo,
                                    'indefinido'=>true,
                                    'bloqueo_consumo'=>$bloqueo_consumo,
                                    'bloqueo_ingreso'=>$bloqueo_ingreso
                                ]);
                                if($bloqueo_socio){
                                    //aumentar contador se se hizo el registro
                                    $contador++;
                                }
                            }
                            //si el registro de datos coincide con el # de socios del derecho
                            if($contador == $buscar_beneficiarios->count()){
                                $request->session()->flash('mensaje', 'El bloqueo para todos los beneficiarios se creó correctamente');
                                return redirect()->route('bloqueo_socio');
                            }else{
                                //si el registro de datos NO coincide con el # de socios del derecho
                                $request->session()->flash('errormensaje', 'No se completó el bloqueo de todos los beneficiarios. Comuníquese con el administrador del sistema');
                                //return redirect()->route('bloqueo_socio');
                                dd('error 7');
                            }
                        }else{
                            //si no hay socios con el derecho enviado
                            $request->session()->flash('errormensaje', 'No se encontraron beneficiaros para esta acción');
                            //return redirect()->route('bloqueo_socio');
                            dd('error 8');
                        }
                        
                }else{
                    //No es bloqueo indefinido x todo el nucleo
                    $buscar_beneficiarios = Socio::select('cedula','accion')->where('accion','=',$accionBloqueo)->get();
                    if($buscar_beneficiarios){     
                        //recorrer array de socios si se encontraron datos
                        foreach ($buscar_beneficiarios as $socio) {
                            $bloqueo_socio = BloqueoSocio::create([
                                'cedula'=>$socio->cedula,
                                'accion'=>$accionBloqueo,
                                'tipo_bloqueo'=>$listado_bloqueos,
                                'indefinido'=>false,
                                'bloqueo_consumo'=>$bloqueo_consumo,
                                'bloqueo_ingreso'=>$bloqueo_ingreso
                            ]);
                            if($bloqueo_socio){
                                 //aumentar contador se se hizo el registro
                                $contador++;
                            }
                        }
                        //si el registro de datos coincide con el # de socios del derecho
                        if($contador == $buscar_beneficiarios->count()){
                            $request->session()->flash('mensaje', 'El bloqueo para todos los beneficiarios se creó correctamente');
                            return redirect()->route('bloqueo_socio');
                        }else{
                            //si el registro de datos NO coincide con el # de socios del derecho
                            $request->session()->flash('errormensaje', 'No se completó el bloqueo de todos los beneficiarios. Comuníquese con el administrador del sistema');
                            //return redirect()->route('bloqueo_socio');
                            dd('error 6');
                        }  
                    }else{
                        $request->session()->flash('errormensaje', 'No se encontraron beneficiaros para esta acción');
                        //return redirect()->route('bloqueo_socio');
                        dd('error 5');
                    }
                }
            }else{
                if($cedulaBloqueo){
                   //Se bloquea un socio del numero de derecho
                    if($bloqueo_indf){
                    // Es bloqueo indefinido
                        $bloqueo_socio = BloqueoSocio::create([
                            'cedula'=>$cedulaBloqueo,
                            'accion'=>$accionBloqueo,
                            'tipo_bloqueo'=>$listado_bloqueos,
                            'fecha_inicio_bloqueo'=>$fecInicioBloqueo,
                            'fecha_fin_bloqueo'=>$fecFinBloqueo,
                            'indefinido'=>true,
                            'bloqueo_consumo'=>$bloqueo_consumo,
                            'bloqueo_ingreso'=>$bloqueo_ingreso
                        ]);
                        // Si se hizo el registro correctamente
                        if($bloqueo_socio){
                            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
                            return redirect()->route('bloqueo_socio');
                        }else{
                            // Si NO se hizo el registro correctamente
                            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuníquese con el administrador del sistema');
                            //return redirect()->route('bloqueo_socio');
                            dd('error 4');
                        }
                    }else{
                        //No es bloqueo indefinido
                        $bloqueo_socio = BloqueoSocio::create([
                            'cedula'=>$cedulaBloqueo,
                            'accion'=>$accionBloqueo,
                            'tipo_bloqueo'=>$listado_bloqueos,
                            'indefinido'=>false,
                            'bloqueo_consumo'=>$bloqueo_consumo,
                            'bloqueo_ingreso'=>$bloqueo_ingreso
                        ]);

                        // Si se hizo el registro correctamente
                        if($bloqueo_socio){
                            $request->session()->flash('mensaje', 'Bloqueo creado correctamente');
                            return redirect()->route('bloqueo_socio');
                        }else{
                            // Si NO se hizo el registro correctamente
                            $request->session()->flash('errormensaje', 'Error al crear bloqueo. Por favor comuníquese con el administrador del sistema');
                            //return redirect()->route('bloqueo_socio');
                            dd('error 3');
                        }

                    }
                }else{
                    // Es bloqueo de un socio pero no hay cedula
                    $request->session()->flash('errormensaje', 'Si no se bloquea toodos los beneficiarios del derecho, la cédula del socio a bloquear es obligatoria');
                    //return redirect()->route('bloqueo_socio');
                    dd('error 2');
                }
            }
        }else{
            // No hay tipo de bloqueo ni numero de derecho
            $request->session()->flash('errormensaje', 'El tipo de bloqueo y accion son datos obligatorios para el registro');
            //return redirect()->route('bloqueo_socio');
            if($listado_bloqueos ){
                dd('error 001 '.$listado_bloqueos." - ".$accionBloqueo);
            }else{
                dd('error 01 '.$listado_bloqueos." - ".$accionBloqueo);
            }

            dd('error 1 '.$listado_bloqueos." - ".$accionBloqueo);
        }
    }
}
