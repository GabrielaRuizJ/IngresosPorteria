<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class PermissionController extends Controller
{
    public function index(){
        
        $permisos = Permission::all()->sortByDesc("id");
        return view('usuarios.permiso',compact('permisos'));
    }

    public function store(Request $request){

        $permisos = Permission::all()->sortByDesc("id");
        $permission = Permission::create(['name' => $request->input('nombrepermiso')]);
        $nomPermiso = $request->input('nombrepermiso');
        $userDat = Auth::user();
        $userIdLog = $userDat->id;
        $userName = $userDat->name;
        $fechaLog = date("Y-m-d H:i:s");
        
        if($permission){
            $guardarLog = Log::create([
                'fecha'   => $fechaLog,
                'accion'  =>'Insert',
                'tabla_accion' => 'Permisos',
                'id_usuario' => $userIdLog,
                'nombre_usuario' => $userName,
                'comentarios'=>'Crear permiso '.$nomPermiso
            ]);
            $request->session()->flash('mensaje', 'Permiso creado correctamente');
            return redirect()->route('permiso');
        }else{
            $request->session()->flash('mensaje', 'Error creando permiso');
            return redirect()->route('permiso');
        }
    
    }

    public function edit($id){
        $permiso = Permission::findOrFail($id);
        $rolesAsignados = $permiso->roles;
        $roles = Role::select('id', 'name')->get();

        $rolesDisponibles = Role::all()->diff($rolesAsignados);

        //$rolesDisponibles = $roles->reject(function ($rol) use ($rolesAsignados) {
        //    return $rolesAsignados->has($rol->id);
        //});
        return view('usuarios.permisoEdit',compact('permiso','rolesAsignados','rolesDisponibles'));

    }

    public function update(Request $request,$id){
        try{
            $validator = Validator::make($request->all(), [
                'nombre' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{

                $permiso = Permission::findOrFail($id);

                $permiso_rol = $request->input('id_rol',[]);
                $permiso->syncRoles($permiso_rol);

                $userDat = Auth::user();
                $userIdLog = $userDat->id;
                $userName = $userDat->name;
                $fechaLog = date("Y-m-d H:i:s");

                //$rolesAsignados = $permiso->roles;
                //$rolesDisponibles = Role::all()->diff($rolesAsignados);

                $permisos = Permission::all()->sortByDesc("id");

                $guardarLog = Log::create([
                    'fecha'   => $fechaLog,
                    'accion'  =>'Update',
                    'tabla_accion' => 'Permisos',
                    'id_usuario' => $userIdLog,
                    'nombre_usuario' => $userName,
                    'comentarios'=>'Modificar datos del permiso #'.$id
                ]);
                $request->session()->flash('mensaje', 'Datos modificados correctamente');
                return redirect()->route('permiso')->with('permisos');

                //return view('usuarios.permisoEdit',compact('permiso','rolesAsignados','rolesDisponibles'));
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
