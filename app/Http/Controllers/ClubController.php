<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    public function index()
    {
        // Lógica para mostrar una lista
        $clubes = DB::table('club')
        ->join('ciudad','ciudad.id','=','club.id_ciudad')
        ->select('ciudad.nombre as ciudad','club.id as id','club.nombre_club as nombre_club','club.direccion as direccion','club.telefono as telefono','club.email1 as email1')
        ->get();
        $ciudades = Ciudad::all();
        return view('parametros.club',compact('clubes','ciudades'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'nombre_club'=>'required',
                'dir_club'=>'required',
                'tel_club'=>'required',
                'email_club'=>'required',
                'ciudad'=>'required',
            ]);

            if($validator->fails()){
                return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
            }else{
                $club = Club::create([
                    'nombre_club'=>$request->nombre_club,
                    'direccion'=>$request->dir_club,
                    'telefono'=>$request->tel_club,
                    'email1'=>$request->email_club,
                    'id_ciudad'=>$request->ciudad
                ]);
                $request->session()->flash('mensaje', 'Club creado correctamente');
                return redirect()->route('clubes');
            }
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }

}
