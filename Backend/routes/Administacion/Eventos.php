<?php
use App\Http\Controllers\Administacion\EventosController;



Route::get('/eventos', [EventosController::class, 'get']);
Route::post('/eventos', [EventosController::class, 'post']);
Route::put('/eventos/{id}', [EventosController::class, 'update']);
Route::delete('/eventos/{id}', [EventosController::class, 'destroy']);
