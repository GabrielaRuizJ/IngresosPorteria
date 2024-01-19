<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index(){
        $datos = User::all();
        return view('usuarios.user',['datos'=>$datos]);
    }
    public function roles(){
        $datos = Role::all();
        return view('usuarios.role',compact('datos'));
    }
    public function create(){
        $role = Role::create(['name' => $request->input('nombrerol')]);
        return back();
    }

    public function store(){

    }
    public function show(){
        
    }
    public function edit(){
        
    }
    public function delete(){
        
    }
}
