<?php


use App\Http\Controllers\Administacion\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'API Iglesia Gracia y Fe';
});

Route::post('/login', [LoginController::class, 'login']);

require_once 'Administacion/Miembros.php';
require_once 'Administacion/Eventos.php';
require_once 'Administacion/Ministerios.php';
require_once 'Administacion/Familias.php';
require_once 'Administacion/Consejerias.php';
require_once 'Administacion/IngresosEgresos.php';


