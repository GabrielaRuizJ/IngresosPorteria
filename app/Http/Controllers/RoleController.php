<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //
    public function index(){
        $roles = Role::all();
        $permisos = Permission::all();
        return view('usuarios.role',compact('roles','permisos'));
    }

    public function create(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|unique:roles,name',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{
                $permisos_add = $request->input('id_permiso',[]);
                $role = Role::create(['name' => $request->input('nombre')]);
                if($permisos_add){
                    $role->syncPermissions($permisos_add);
                }

                $roles = Role::all();
                $permisos = Permission::all();
                $mensaje = "Se agregó el dato correctamente";
                return view('usuarios.role',compact('roles','permisos','mensaje'));
            }
            
            
        }catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function edit($id){

        $role = Role::findByName($id);
        $permisosAsignados = $role->permissions;
        $permisosDisponibles = Permission::all()->diff($permisosAsignados);
        return view('usuarios.roleEdit',compact('role','permisosAsignados','permisosDisponibles'));
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

                $role = Role::findByName($id);
                $role->name = $request->input('nombre');
                $role->save();

                $role_permiso = $request->input('id_permiso',[]);
                $role->syncPermissions($role_permiso);

                $permisosAsignados = $role->permissions;
                $permisosDisponibles = Permission::all()->diff($permisosAsignados);
                $mensaje = 'Los datos se actualizaron de manera correcta';

                return view('usuarios.roleEdit',compact('role','permisosAsignados','permisosDisponibles'));
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function store(){

    }

    public function show(){
        
    }

    public function delete(){
        
    }
}
