<?php

namespace App\Http\Controllers;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function index(){
        $roles = Rol::all();
        return view("usuarios.role", compact('roles'));
    }

    public function store(Request $request){

        $rol = new Rol();
        $roles = Rol::all();
        $validator = Validator::make($request->all(),[
            'nombre'=>'required|unique:rol,nombre'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }else{
            $rol->create($request->all());
            return back()->with(compact('roles'));
        }
        
    }

    public function edit($id){
        $role = Rol::find($id);
        $permisos = DB::select('CALL buscar_permisos_rol(?)',[$id]);
        $rolpermiso = DB::table('rol_permiso')
        ->join('permiso','rol_permiso.id_permiso','=','permiso.id')
        ->select('rol_permiso.id_rol as id_rol','rol_permiso.id_permiso as id_permiso','permiso.nombre as permiso')
        ->get();
        $permisosRol = DB::table('rol_permiso');
        return view('usuarios.rolePermiso',compact('role','permisos','rolpermiso'));
    }


}
