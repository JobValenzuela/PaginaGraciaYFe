<?php
use App\Http\Controllers\Administacion\PeticionesController;



Route::get('/peticiones', [PeticionesController::class, 'get']);
Route::post('/peticiones', [PeticionesController::class, 'post']);
Route::put('/peticiones/{id}', [PeticionesController::class, 'update']);
Route::delete('/peticiones/{id}', [PeticionesController::class, 'destroy']);
