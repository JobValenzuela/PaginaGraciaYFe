<?php
use App\Http\Controllers\Administacion\MiembrosController;



Route::get('/miembros', [MiembrosController::class, 'get']);
Route::post('/miembros', [MiembrosController::class, 'post']);
Route::put('/miembros/{id}', [MiembrosController::class, 'update']);
Route::delete('/miembros/{id}', [MiembrosController::class, 'destroy']);
