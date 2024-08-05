<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\personaController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/personas/list', [personaController::class, 'list']);
Route::get('/personas/listOne/{id}', [personaController::class, 'listOne']);
Route::post('/personas/create', [personaController::class, 'create']);
Route::put('/personas/update/{id}', [personaController::class, 'update']);
Route::delete('/personas/delete/{id}', [personaController::class, 'delete']);
Route::get('/personas/restore/{id}', [personaController::class, 'restore']);