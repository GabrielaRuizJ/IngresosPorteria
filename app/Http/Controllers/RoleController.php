<?php

namespace App\Http\Controllers;
//use App\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index(){
        $datos = Role::all();
        return view('usuarios.role',compact('datos'));
    }

    public function create(Request $request){
        $role = Role::create(['name' => $request->input('nombrerol')]);
        return back();
    }

    public function edit(){
        return view('usuarios.rolepermiso');
        /*$role = Role::find($id);
        $permisos = Permission::all();
        return view('usuarios.rolepermiso.edit',compact('role','permisos'));*/
    }

    public function update(){

    }

    public function store(){

    }

    public function show(){
        
    }

    public function delete(){
        
    }
}
