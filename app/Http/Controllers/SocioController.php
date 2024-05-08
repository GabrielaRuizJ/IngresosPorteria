<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;

class SocioController extends Controller
{
    public function index(){
        $datos = Socio::all();
        return view('socios.socios',['socios'=>$datos]);
    }
}
