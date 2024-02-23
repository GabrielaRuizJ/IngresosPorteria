<?php

namespace App\Http\Controllers;
use App\Models\RolPermiso;
use App\Models\Rol;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolPermisoController extends Controller
{
    public function update(Request $request,$id){

        $rolpermiso = new RolPermiso;
       
        if($id){

            $rol_update = Rol::find($id);
            $rol_update->nombre =$request->input('nombre');
            $rol_update->save();
            
            $permisos = $request->input('id_permiso_create',[]);
            
            $permisos2 = $request->input('id_permiso',[]);
            $opciones_actuales=RolPermiso::where('id_rol',$id)->get()->pluck('id_permiso')->toArray();    
            $opciones_eliminadas=array_diff($opciones_actuales,$permisos2);

            if($opciones_eliminadas){
                $aux=array();
                foreach ($opciones_eliminadas as $ind=> $op){
                    array_push($aux,$ind);
                }
                    
                foreach ($aux as $eliminados)
                {
                    RolPermiso::where('id_permiso',$eliminados)->where('id_rol', $id)->delete();
                }
            }
            if($permisos){
                foreach ($permisos as $permiso){
                    $datos = [
                        'id_rol'=>$id,
                        'id_permiso'=>$permiso
                    ];
                    RolPermiso::create($datos);
                }
            }
            
            $roles = Rol::all();
            $mensaje = 'Los datos se actualizaron de manera correcta';
            return view('usuarios.role',compact('mensaje','roles'));
        }
            
    }
    public function store(){

    }
}
