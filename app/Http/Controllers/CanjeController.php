<?php

namespace App\Http\Controllers;
use App\Models\Canje;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CanjeController extends Controller
{
    public function index(){
        $canjes = Canje::select('ingreso.nombre as nombre_canje', 'detalle_canje.*')
        ->join('ingreso', 'ingreso.id', '=', 'detalle_canje.id_ingreso')
        ->get();
        return view("canjes.canje",compact('canjes'));
    }
}
