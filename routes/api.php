<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\IngresoController;
 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/apiInv',[IngresoController::class,'consultarIngreso'])->name('apiInv');
Route::get('/apiCanje',[IngresoController::class,'consultaCanje'])->name('apiCanje');
Route::post('/guardarIngreso',[IngresoController::class,'store'])->name('guardarIngreso');
