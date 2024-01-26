<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $datos = Permission::all();
        return view('usuarios.permiso',compact('datos'));
    }

    public function store(Request $request){
        $permission = Permission::create(['name' => $request->input('nombrepermiso')]);
        return back();
    }
    public function edit(){
        return back();
    }

}
