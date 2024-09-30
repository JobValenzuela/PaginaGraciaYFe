<?php
use App\Http\Controllers\Administacion\UsuariosController;



Route::get('/usuarios', [UsuariosController::class, 'get']);
Route::post('/usuarios', [UsuariosController::class, 'post']);
Route::put('/usuarios/{id}', [UsuariosController::class, 'update']);
Route::delete('/usuarios/{id}', [UsuariosController::class, 'destroy']);
