<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
{
    public function index(){
        
        $permisos = Permission::all()->sortByDesc("id");
        return view('usuarios.permiso',compact('permisos'));
    }

    public function store(Request $request){
        $permisos = Permission::all()->sortByDesc("id");
        $permission = Permission::create(['name' => $request->input('nombrepermiso')]);
        $request->session()->flash('mensaje', 'Permiso creado correctamente');
        return redirect()->route('permiso');
    }

    public function edit($id){
        $permiso = Permission::findOrFail($id);
        $rolesAsignados = $permiso->roles;
        $roles = Role::select('id', 'name')->get();
        $rolesDisponibles = $roles->reject(function ($rol) use ($rolesAsignados) {
            return $rolesAsignados->has($rol->id);
        });
        return redirect()->route('usuarios.permisoEdit')->with('permiso','rolesAsignados','rolesDisponibles');
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

                $rolesAsignados = $permiso->roles;
                $rolesDisponibles = Role::all()->diff($rolesAsignados);
                $mensaje = 'Los datos se actualizaron de manera correcta';

                return view('usuarios.permisoEdit',compact('permiso','rolesAsignados','rolesDisponibles'));
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

}
