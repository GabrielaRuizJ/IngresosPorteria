<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsuarioImport;
use App\Imports\UsuarioCollectionImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(){
        $datos = User::all();
        return view('usuarios.user',['datos'=>$datos]);
    }

    public function store(Request $request){

        $datos = User::all();
        if ($request->hasFile('user_import')) {

            try{
                $validator = Validator::make($request->all(), [
                    'user_import' => 'required|mimes:csv,txt|max:10240',
                ]);
                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }else{
                    try{

                        $user_import_dat  = $request->file('user_import');
                        /*Excel::import(new UsuarioImport,$user_import_dat);  */

                        $import = new UsuarioCollectionImport;
                        $collection = Excel::import($import,$user_import_dat);
                        $usuariosData = $import->getUsuariosData();

                        foreach ($usuariosData as $usuarioData) {                            
                            $usuario = User::where('cedula', $usuarioData['cedula'])->first();
                            if ($usuario) {
                                $rolNombre = $usuarioData['rol'];
                                $rol = Role::where('name', $rolNombre)->first();
                                if ($rol) {
                                    $usuario->assignRole($rol);
                                }
                            }
                        }

                        $request->session()->flash('mensaje', 'Los datos fueron importados con exito ');
                        return redirect()->route('user');

                    }catch (\Exception $e) {
                        dd($e->getMessage());
                    }
                }
                
            }catch (\Exception $e) {
                dd($e->getMessage());
            }
            
        }else{
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'username' => ['required', 'string', 'max:30'],
                    'cedula' => ['required', 'string', 'max:30'],
                    'email' => ['required','string', 'email', 'max:255'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
    
                $user = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'cedula' => $request->cedula,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'estado'=> $request->estado,
                ]);
                $request->session()->flash('mensaje', 'Usuario creado correctamente');
                return redirect()->route('user');
        }
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $roles = Role::all();
        $roles_usuario  = $user->roles->pluck('id')->toArray();
        return view('usuarios.userEdit',compact('user','roles','roles_usuario'));
    }

    public function update(Request $request,$id){
        try{
            $validator = Validator::make($request->all(), [
                'nombre' => 'required',
                'username'=>'required|unique:users,username,'.$id,
                'cedula'=>'required|unique:users,username,'.$id,
                'email'=>'required',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }else{

                $usuario = User::findOrFail($id);
                
                $usuario->name = $request->input('nombre');
                $usuario->username = $request->input('username');
                $usuario->cedula = $request->input('cedula');
                $usuario->email = $request->input('email');
                if($request->has('estado')){
                    $usuario->estado = 1;
                }else{
                    $usuario->estado = 0;
                }

                $usuario->save();
                
                $role_user = $request->input('id_rol',[]);
                $usuario->syncRoles($role_user);

                $user = User::findOrFail($id);
                $roles = Role::all();
                $roles_usuario  = $user->roles->pluck('id')->toArray();
                $request->session()->flash('mensaje', 'Datos modificados correctamente');
                return redirect()->route('user')->with('user','roles','roles_usuario');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
       
    }
    
}
