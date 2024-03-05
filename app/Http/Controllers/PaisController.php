<?php

namespace App\Http\Controllers;
use App\Models\Pais;
use App\Imports\PaisImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
        if ($request->hasFile('paises_import')) {
            try{
                $validator = Validator::make($request->all(), [
                    'paises_import' => 'required|mimes:csv,txt|max:10240',
                ]);
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }else{
                    try{
                        $file  = $request->file('paises_import');
                        Excel::import(new PaisImport,$file);  
                        session()->flash('mensaje',"Los datos fueron importados con exito");
                        return redirect()->route('paises');
                    }catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
                
            }catch (\Exception $e) {
                dd($e->getMessage());
            }
            
        }else{
            $validator = Validator::make($request->all(), [
                'nombre_pais' => 'required|unique:pais,nombre_pais',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{
                
                $pais = Pais::create(['nombre_pais' => $request->input('nombre_pais')]);
                $mensaje = "Pais creado correctamente";
                session()->flash('mensaje',"Pais creado correctamente");
                return redirect()->route('paises');
            }
        }
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
