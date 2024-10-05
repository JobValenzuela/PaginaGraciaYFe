<?php
use App\Http\Controllers\Administacion\MobiliarioController;



Route::get('/mobiliario', [MobiliarioController::class, 'get']);
Route::post('/mobiliario', [MobiliarioController::class, 'post']);
Route::put('/mobiliario/{id}', [MobiliarioController::class, 'update']);
Route::delete('/mobiliario/{id}', [MobiliarioController::class, 'destroy']);
