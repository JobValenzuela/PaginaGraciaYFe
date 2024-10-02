<?php
use App\Http\Controllers\Administacion\RolController;



Route::get('/roles', [RolController::class, 'get']);
Route::post('/roles', [RolController::class, 'post']);
Route::put('/roles/{id}', [RolController::class, 'update']);
Route::delete('/roles/{id}', [RolController::class, 'destroy']);
