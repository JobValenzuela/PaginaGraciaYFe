<?php

use App\Http\Controllers\LideresMinisteriosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MiembrosController;
use App\Http\Controllers\CatalogoMinisteriosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API Iglesia Gracia y Fe';
});

Route::post('/login', [LoginController::class, 'login']);

Route::get('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'get']);
Route::post('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'post']);
Route::put('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'update']);
Route::delete('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'destroy']);

Route::get('/lideres/ministerios', [LideresMinisteriosController::class, 'get']);
Route::post('/lideres/ministerios', [LideresMinisteriosController::class, 'post']);
Route::put('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'update']);
Route::delete('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'destroy']);

Route::get('/miembros', [MiembrosController::class, 'get']);
Route::post('/miembros', [MiembrosController::class, 'post']);
Route::put('/miembros/{id}', [MiembrosController::class, 'update']);
Route::delete('/miembros/{id}', [MiembrosController::class, 'destroy']);

