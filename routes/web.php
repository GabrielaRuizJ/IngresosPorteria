<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\BloqueoController;
use App\Http\Controllers\BloqueoSocioController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\AutorizadoController;
use App\Http\Controllers\CanjeController;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/usuarios',[UserController::class,'index'])->name('user');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/usuarios', [UserController::class, 'store'])->name('user.import');
    Route::get('/usuarios/userEdit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::post('/usuarios/userEdit/{id}',[UserController::class,'update'])->name('user.update');

    Route::get('/usuarios/role',[RoleController::class,'index'])->name('role');
    Route::post('/usuarios/role',[RoleController::class,'store'])->name('role.create');
    Route::get('/usuarios/roleEdit/{id}',[RoleController::class,'edit'])->name('role.edit');
    Route::post('/usuarios/roleEdit/{id}',[RoleController::class,'update'])->name('role.update');

    Route::get('/usuarios/permiso',[PermissionController::class,'index'])->name('permiso');
    Route::post('/usuarios/permiso',[PermissionController::class,'store'])->name('permiso.create');
    Route::get('/usuarios/permiso/{id}',[PermissionController::class,'edit'])->name('permiso.edit');
    Route::post('/usuarios/permiso/{id}',[PermissionController::class,'update'])->name('permiso.update');

    Route::get('/parametros/pais',[PaisController::class,'index'])->name('paises');
    Route::post('/parametros/pais',[PaisController::class,'store'])->name('pais.store');
    
    Route::get('/parametros/ciudad',[CiudadController::class,'index'])->name('ciudades');
    Route::post('/parametros/ciudad',[CiudadController::class,'store'])->name('ciudad.create');
    Route::get('/parametros/ciudadEdit/{idc}',[CiudadController::class,'edit'])->name('ciudad.edit');
    Route::post('/parametros/ciudadEdit/{id}',[CiudadController::class,'update'])->name('ciudad.update');

    
    Route::get('/parametros/club',[ClubController::class,'index'])->name('clubes');
    Route::post('/parametros/club',[ClubController::class,'store'])->name('club.create');
    Route::get('/parametros/clubEdit/{id}',[ClubController::class,'edit'])->name('club.edit');
    Route::post('/parametros/clubEdit/{id}',[ClubController::class,'update'])->name('club.update');

    Route::get('/parametros/tipoIngreso',[TipoIngresoController::class,'index'])->name('tipo_ingreso');
    Route::post('/parametros/tipoIngreso',[TipoIngresoController::class,'store'])->name('tipo_ingreso.create');

    Route::get('/parametros/tipoVehiculo',[TipoVehiculoController::class,'index'])->name('tipo_vehiculo');
    Route::post('/parametros/tipoVehiculo',[TipoVehiculoController::class,'store'])->name('tipo_vehiculo.create');

    Route::get('/ingresos/ingreso',[IngresoController::class,'index'])->name('ingresos');
    Route::get('/ingresos/salida',[IngresoController::class,'ingresosHoy'])->name('salidas');
    Route::post('/ingresos/salidaMasiva',[IngresoController::class,'salidaMSV'])->name('salidamasiva');
    Route::post('/ingresos/salida',[SalidaController::class,'store'])->name('salida.create');

    Route::get('/ingresos/listadoIngresos',[IngresoController::class,'busquedaIngresos'])->name('listadoIngresos');
    Route::post('/ingresos/resultadobingresos',[IngresoController::class,'resultadoBusquedaIngresos'])->name('resBusquedaIngresos');
    
    Route::get('/socios/socios',[SocioController::class,'index'])->name('socios');
    Route::post('/socios/socios',[SocioController::class,'store'])->name('socio.create');

    Route::get('/socios/bloqueos',[BloqueoController::class,'index'])->name('bloqueos');
    Route::post('/socios/bloqueos',[BloqueoController::class,'store'])->name('bloqueo.create');
    
    Route::get('/socios/bloqueoSocio',[BloqueoSocioController::class,'index'])->name('bloqueo_socio');
    Route::post('/socios/bloqueoSocio',[BloqueoSocioController::class,'store'])->name('bloqueo_socio.create');

    Route::get('/autorizados/autorizado',[AutorizadoController::class,'index'])->name('autorizados');
    Route::post('/autorizados/autorizado',[AutorizadoController::class,'store'])->name('autorizado.create');
    Route::delete('/autorizados/autorizado',[AutorizadoController::class,'delete'])->name('autorizado.delete');

    Route::get('/canjes/canje',[CanjeController::class,'index'])->name('canjes');
    
});


require __DIR__.'/auth.php';
