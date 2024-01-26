<?php

namespace App\Http\Controllers;
use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        // Lógica para mostrar una lista
        $paises = Pais::all();
        return view('parametros.pais',compact('paises'));
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
        $pais = Pais::create(['nombre_pais' => $request->input('nombre_pais')]);
        return back();
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
