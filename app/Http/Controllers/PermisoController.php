<?php

namespace App\Http\Controllers;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PermisoController extends Controller
{
    public function index(){
        $permisos = Permiso::all();
        $tablas = DB::select("SELECT table_name as tabla FROM  INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = 'club' and (table_name!='failed_jobs' AND table_name!='migrations' AND table_name!='password_resets' AND table_name!='personal_access_tokens') ");
        return view("usuarios.permiso",compact('permisos','tablas'));
    }

    public function store(Request $request){
        $permiso = new Permiso;
        $tablas = DB::select("SELECT table_name as tabla FROM  INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = 'club' and (table_name!='failed_jobs' AND table_name!='migrations' AND table_name!='password_resets' AND table_name!='personal_access_tokens')");
        $validator = Validator::make($request->all(), [
            'nombre'=>'required|unique:permiso,nombre',
            'accion'=>'required',
            'tabla'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $permiso->create($request->all());
            $permisos = Permiso::all();
            return back()->with(compact('permisos','tablas'));
        }

    }
}
