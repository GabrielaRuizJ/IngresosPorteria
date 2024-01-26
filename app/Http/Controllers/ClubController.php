<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        // Lógica para mostrar una lista
        $clubes = Club::all();
        return view('parametros.club',compact('clubes'));
    }

    public function show($id)
    {
        // Lógica para mostrar un elemento específico
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación
    }

    public function store(Request $request)
    {
        // Lógica para guardar un nuevo elemento
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un elemento
    }

    public function destroy($id)
    {
        // Lógica para eliminar un elemento
    }
}
