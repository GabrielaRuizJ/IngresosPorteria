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
    Route::get('/parametros/ciudadEdit/{idc}{idp}',[CiudadController::class,'edit'])->name('ciudad.edit');
    Route::post('/parametros/ciudadEdit/{id}',[CiudadController::class,'update'])->name('ciudad.update');

    
    Route::get('/parametros/club',[ClubController::class,'index'])->name('clubes');
    Route::post('/parametros/club',[ClubController::class,'store'])->name('club.create');
    Route::get('/parametros/clubEdit{id}',[ClubController::class,'edit'])->name('club.edit');

    Route::get('/parametros/tipoIngreso',[TipoIngresoController::class,'index'])->name('tipo_ingreso');
    Route::post('/parametros/tipoIngreso',[TipoIngresoController::class,'store'])->name('tipo_ingreso.create');

    Route::get('/parametros/tipoVehiculo',[TipoVehiculoController::class,'index'])->name('tipo_vehiculo');
    Route::post('/parametros/tipoVehiculo',[TipoVehiculoController::class,'store'])->name('tipo_vehiculo.create');

    Route::get('/ingresos/ingreso',[IngresoController::class,'index'])->name('ingresos');
    Route::post('/ingresos/ingreso',[IngresoController::class,'store'])->name('ingresos');
});


require __DIR__.'/auth.php';
