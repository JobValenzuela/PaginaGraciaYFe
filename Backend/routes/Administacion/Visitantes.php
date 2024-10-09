<?php
use App\Http\Controllers\Administacion\VisitanteController;



Route::get('/visitantes', [VisitanteController::class, 'get']);
Route::post('/visitantes', [VisitanteController::class, 'post']);
Route::post('convertir/visitantes', [VisitanteController::class, 'post']);
Route::put('/visitantes/{id}', [VisitanteController::class, 'update']);
Route::delete('/visitantes/{id}', [VisitanteController::class, 'destroy']);
