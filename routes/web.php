<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\CiudadController;
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
    Route::get('/usuarios/role',[RoleController::class,'index'])->name('role');
    Route::post('/usuarios/role',[RoleController::class,'create'])->name('role.create');
    Route::patch('/usuarios/rolePermiso',[RoleController::class,'edit'])->name('role.edit');
    Route::get('/usuarios/rolePermiso',[PermissionController::class,'edit'])->name('rolepermiso');
    Route::get('/usuarios/permiso',[PermissionController::class,'index'])->name('permiso');
    Route::post('/usuarios/permiso',[PermissionController::class,'store'])->name('permiso.create');
    Route::get('/parametros/club',[ClubController::class,'index'])->name('clubes');
    Route::get('/parametros/pais',[PaisController::class,'index'])->name('paises');
    Route::post('/parametros/pais',[PaisController::class,'store'])->name('pais.store');
    Route::get('/parametros/ciudad',[CiudadController::class,'index'])->name('ciudades');
    Route::post('/parametros/ciudad',[CiudadController::class,'store'])->name('ciudad.create');
    Route::get('/parametros/ciudadEdit/{idc}{idp}',[CiudadController::class,'edit'])->name('ciudad.edit');

});
/*Route::middleware('Role')->group(function () {
   
    //Route::get('/usuarios',[RoleController::class,'user'])->name('user');
});*/


require __DIR__.'/auth.php';
