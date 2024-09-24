<?php
use App\Http\Controllers\Administacion\ConsejeriaController;



Route::get('/consejerias', [ConsejeriaController::class, 'get']);
Route::post('/consejerias', [ConsejeriaController::class, 'post']);
Route::put('/consejerias/{id}', [ConsejeriaController::class, 'update']);
Route::delete('/consejerias/{id}', [ConsejeriaController::class, 'destroy']);
