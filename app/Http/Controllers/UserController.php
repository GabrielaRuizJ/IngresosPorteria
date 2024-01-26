<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $datos = User::all();
        return view('usuarios.user',['datos'=>$datos]);
    }
}
