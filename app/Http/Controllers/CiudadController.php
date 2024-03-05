<?php

namespace App\Http\Controllers;
use App\Models\Ciudad;
use App\Models\Pais;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index(){
        $ciudades = DB::table('ciudad')
        ->join('pais','ciudad.id_pais','=','pais.id')
        ->select('ciudad.id as ciudad','ciudad.nombre as nombreciudad','pais.nombre_pais as pais','pais.id as idpais')
        ->get();
        $paises = Pais::all();
        return view("parametros.ciudad",compact('ciudades','paises'));
    }

    public function store(Request $request){
        try {

            $ciudades = DB::table('ciudad')
            ->join('pais','ciudad.id_pais','=','pais.id')
            ->select('ciudad.id as ciudad','ciudad.nombre as nombreciudad','pais.nombre_pais as pais','pais.id as idpais')
            ->get();
            $paises = Pais::all();
            $request->validate([
                'nombre' => 'required',
                'id_pais'=>'required',
            ]);
            
            $ciudad = Ciudad::create(['nombre'=>$request->input('nombre'),'id_pais'=>$request->input('id_pais')]);
            
            
            $request->session()->flash('mensaje', 'Ciudad creada correctamente');
            return redirect()->route('ciudades');
        
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

    public function update(Request $request,$id){
        try {
            $request->validate([
                'nombre' => 'required',
                'id_pais'=>'required',
            ]);
            $ciudad = Ciudad::find($id);
            $ciudad->nombre =$request->input('nombre');
            $ciudad->id_pais =$request->input('id_pais');
            $ciudad->save();

            $ciudades = DB::table('ciudad')
            ->join('pais','ciudad.id_pais','=','pais.id')
            ->select('ciudad.id as ciudad','ciudad.nombre as nombreciudad','pais.nombre_pais as pais','pais.id as idpais')
            ->get();
            $paises = Pais::all();
            return view("parametros.ciudad",compact('ciudades','paises'));
                    
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($idciudad,$idpais){
        try {
            $ciudades = DB::table('ciudad')
            ->join('pais','ciudad.id_pais','=','pais.id')
            ->select('ciudad.id as ciudad','ciudad.nombre as nombreciudad','pais.nombre_pais as pais','pais.id as idpais')
            ->where('ciudad.id','=',$idciudad)
            ->get();
            $paises =DB::table('pais')
            ->where('pais.id','!=',$idpais)
            ->get();
            $idc=$idciudad;
            return view("parametros.ciudadEdit",compact("ciudades","paises","idc"));
        
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }

}
