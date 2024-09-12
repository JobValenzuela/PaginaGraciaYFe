<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MinisterioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API Iglesia Gracia y Fe';
});

Route::post('/login', [LoginController::class, 'login']);

Route::get('/ministerios', [MinisterioController::class, 'get']);
Route::post('/ministerios', [MinisterioController::class, 'post']);
Route::put('/ministerios/{id}', [MinisterioController::class, 'update']);
Route::delete('/ministerios/{id}', [MinisterioController::class, 'destroy']);
