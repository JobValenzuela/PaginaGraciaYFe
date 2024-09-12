<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\TokenUserHandler;
use Symfony\Component\HttpFoundation\Response;

/*
 * Middleware para la verificación del token del usuario/administrador.
 * Verifica que el token sea válido, el email esté verificado y los permisos necesarios.
 */
class Auth
{
    /**
     * Maneja la solicitud entrante.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $PERMISSIONS
     * @return Response
     */

     const ADMIN = 'ADMIN';
     const PASO = 'PASO';
     const ESPECIALISTA = 'ESPECIALISTA';
     const PACIENTE = 'PACIENTE';
     const FARMACIA = 'FARMACIA';

    public function handle(Request $request, Closure $next, $PERMISSIONS): Response
    {
        // Obtiene la API Key del encabezado de la solicitud
        $token = $request->header('Token');

        // Verifica que la API Key esté presente
        if (!isset($token)) {
            return ApiResponse::response(status: 'error', code: 401, msg: 'No api key');
        }

        // Decodifica el token del usuario
        $user = TokenUserHandler::decode($token);

        // Verifica que el token sea válido
        if ($user === TokenUserHandler::INVALID_TOKEN) {
            return ApiResponse::response(status: 'error', code: 401, msg: 'No valid token');
        }

        // Establece el usuario autenticado en la aplicación
        \Illuminate\Support\Facades\Auth::setUser($user);

        $userPermission = $user->tipo_usuario;

        if($PERMISSIONS === $userPermission) {
            return $next($request);
        } else {
            return ApiResponse::response(status: 'error', code: 403, msg: 'No auth');
        }
    }
}
