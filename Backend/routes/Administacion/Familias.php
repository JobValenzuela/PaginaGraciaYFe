<?php
use App\Http\Controllers\Administacion\CatalogoFamiliasController;
use App\Http\Controllers\Administacion\MiembrosFamiliasController;



Route::get('/catalogo/familias', [CatalogoFamiliasController::class, 'get']);
Route::post('/catalogo/familias', [CatalogoFamiliasController::class, 'post']);
Route::put('/catalogo/familias/{id}', [CatalogoFamiliasController::class, 'update']);
Route::delete('/catalogo/familias/{id}', [CatalogoFamiliasController::class, 'destroy']);



Route::get('/miembros/familias/{id}', [MiembrosFamiliasController::class, 'get']);
Route::post('/miembros/familias', [MiembrosFamiliasController::class, 'post']);
Route::delete('/miembros/familias/{id}', [MiembrosFamiliasController::class, 'destroy']);
