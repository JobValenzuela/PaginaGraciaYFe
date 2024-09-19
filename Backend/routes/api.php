<?php

use App\Http\Controllers\LideresMinisteriosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MiembrosController;
use App\Http\Controllers\CatalogoMinisteriosController;
use App\Http\Controllers\ParticipantesMinisteriosController;
use App\Http\Controllers\EventosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API Iglesia Gracia y Fe';
});

Route::post('/login', [LoginController::class, 'login']);

Route::get('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'get']);
Route::post('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'post']);
Route::put('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'update']);
Route::delete('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'destroy']);

Route::get('/eventos', [EventosController::class, 'get']);
Route::post('/eventos', [EventosController::class, 'post']);
Route::put('/eventos/{id}', [EventosController::class, 'update']);
Route::delete('/eventos/{id}', [EventosController::class, 'destroy']);

Route::get('/lideres/ministerios', [LideresMinisteriosController::class, 'get']);
Route::post('/lideres/ministerios', [LideresMinisteriosController::class, 'post']);
Route::put('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'update']);
Route::delete('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'destroy']);

Route::get('/participantes/ministerios', [ParticipantesMinisteriosController::class, 'get']);
Route::post('/participantes/ministerios', [ParticipantesMinisteriosController::class, 'post']);
Route::delete('/participantes/ministerios/{id}', [ParticipantesMinisteriosController::class, 'destroy']);

Route::get('/miembros', [MiembrosController::class, 'get']);
Route::post('/miembros', [MiembrosController::class, 'post']);
Route::put('/miembros/{id}', [MiembrosController::class, 'update']);
Route::delete('/miembros/{id}', [MiembrosController::class, 'destroy']);

