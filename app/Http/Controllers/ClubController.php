<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function index()
    {
        // Lógica para mostrar una lista
        $clubes = Club::all();
        return view('parametros.club',compact('clubes'));
    }
#Codigo comentado porque no se insertan ni modifican 
#datos de los clubes para canje desde el sistema    
/*
    public function store(){
        $response = Http::get('http://localhost/prueba/apiSyncClubes.php');
        $data1 = json_decode($response);
                    
        if($data1->respuesta == 200){
            $datos_api = $data1->datos;
            $contClubUpdate = 0;
            $contClubNew = 0;
            $cont = 0;
            $cedula_b = "";
            foreach($datos_api as $dat_club ){
                $buscarClub = Club::where('id', $dat_club->id)
                ->update([
                    'club' =>  $dat_club->club,
                    'pbx' =>  $dat_club->pbx,
                    'correo' =>  $dat_club->correo,
                    'estado' =>  $dat_club->estado
                ]);
                if($buscarClub){
                    $contClubUpdate++;
                }else{
                    $crearClub = Club::create([
                        'id' =>  $dat_club->id,
                        'club' =>  $dat_club->club,
                        'pbx' =>  $dat_club->pbx,
                        'correo' =>  $dat_club->correo,
                        'estado' =>  $dat_club->estado
                    ]);
                    if($crearClub){
                        $contClubNew++;
                    }
                   
                }
                $cont++;
            }
            if($cont)
            $datos_respuesta = "<h4>Resultado de la sincronizacion</h4>";
            $datos_respuesta .="<label>Total de clubes recibidos en el servicio: </label>".$cont;
            $datos_respuesta .="<label>Total de clubes actualizados: </label>".$contClubUpdate;
            $datos_respuesta .="<label>Total de clubes nuevos registrados: </label>".$contClubNew;

            session()->flash('mensaje',$datos_respuesta);
            return redirect()->route('clubes');
            //dd($datos_respuesta);
        }else{
            $data = json_encode(array($data1->datos));
            session()->flash('mensaje',json_encode($data));
            return redirect()->route('clubes');
            //dd($data);
        }
    }


    public function edit($id){
        $clubdat = DB::table('club')
        ->join('ciudad','ciudad.id','=','club.id_ciudad')
        ->where('club.id',$id)
        ->select('club.id as id','club.id_ciudad as idciudad','ciudad.nombre as ciudad','club.nombre_club as nombre_club','club.direccion as direccion','club.telefono as telefono','club.email1 as email1')
        ->get();
        $ciudades = Ciudad::all();
        $club = club::find($id);
        return view('parametros.clubEdit',compact('club','clubdat','ciudades'));
    }

    public function update(Request $request,$id){
        try{
            $validator = Validator::make($request->all(), [
                'nombre'=>'required',
                'direccion'=>'required',
                'telefono'=>'required',
                'email1'=>'required',
                'ciudad'=>'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{

                $club = Club::findOrFail($id);
                $club->nombre_club =$request->input('nombre');
                $club->direccion =$request->input('direccion');
                $club->telefono =$request->input('telefono');
                $club->email1 =$request->input('email1');
                $club->id_ciudad =$request->input('ciudad');
                $club->save();

                $clubes = DB::table('club')
                ->join('ciudad','ciudad.id','=','club.id_ciudad')
                ->select('ciudad.nombre as ciudad','club.id as id','club.nombre_club as nombre_club','club.direccion as direccion','club.telefono as telefono','club.email1 as email1')
                ->get();
                $ciudades = Ciudad::all();
                $request->session()->flash('mensaje', 'Datos modificados correctamente');
                return redirect()->route('clubes')->with('clubes','ciudades');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
*/
}
