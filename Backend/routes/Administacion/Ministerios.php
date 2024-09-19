<?php


use App\Http\Controllers\Administacion\LideresMinisteriosController;
use App\Http\Controllers\Administacion\CatalogoMinisteriosController;
use App\Http\Controllers\Administacion\ParticipantesMinisteriosController;


Route::get('/lideres/ministerios', [LideresMinisteriosController::class, 'get']);
Route::post('/lideres/ministerios', [LideresMinisteriosController::class, 'post']);
Route::put('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'update']);
Route::delete('/lideres/ministerios/{id}', [LideresMinisteriosController::class, 'destroy']);

Route::get('/participantes/ministerios', [ParticipantesMinisteriosController::class, 'get']);
Route::post('/participantes/ministerios', [ParticipantesMinisteriosController::class, 'post']);
Route::delete('/participantes/ministerios/{id}', [ParticipantesMinisteriosController::class, 'destroy']);


Route::get('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'get']);
Route::post('/catalogo/ministerios', [CatalogoMinisteriosController::class, 'post']);
Route::put('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'update']);
Route::delete('/catalogo/ministerios/{id}', [CatalogoMinisteriosController::class, 'destroy']);


