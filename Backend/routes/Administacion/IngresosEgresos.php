<?php
use App\Http\Controllers\Administacion\IngresosEgresosController;



Route::get('/IngresosEgresos', [IngresosEgresosController::class, 'get']);
Route::post('/IngresosEgresos', [IngresosEgresosController::class, 'post']);
Route::put('/IngresosEgresos/{id}', [IngresosEgresosController::class, 'update']);
Route::delete('/IngresosEgresos/{id}', [IngresosEgresosController::class, 'destroy']);

