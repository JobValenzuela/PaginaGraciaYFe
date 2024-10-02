<?php

namespace App\Http\Helpers;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Log;

class TokenUserHandler
{
    const INVALID_TOKEN = -1;

    /*
     * Esta función se encarga de crear el token para el usuario, en dicho token se almacena la información del id
     * y si es un administrador o no, la fecha de inicio del token y la fecha de expiración
     */
    public static function encode(User $user)
    {
        $jwt_secret = env('JWT_SECRET');

        $payload = [
            'id_usuario' => $user->id_usuario,
            'init' => time(),
            'exp' => time() + (60 * 60 * 6), // 6 hr para que expire el token
        ];

        $jwt = JWT::encode($payload, $jwt_secret, 'HS256');

        return $jwt;
    }

    /*
     * Esta función se encarga de decodificar el token, si el token es correcto entonces retornará el usuario auntenticado,
     * en caso contrario la función retornará un INVALID_TOKEN, los requerimientos que debe cumplir el token son
     * los siguientes: el token debe contener todos los campos, debe de estar vigente, es decir, que su fecha de expiración
     * no haya llegado, debe de comprobarse que no se esté usando el token antes de su fecha de creación, que el usuario esté
     * activo, y, finalmente, verificamos que el token le pertenezca a un usuario de la base de datos
     */
    public static function decode(string $jwt)
    {
        $jwt_secret = env('JWT_SECRET');

        try {
            $token = JWT::decode($jwt, new Key($jwt_secret, 'HS256'));

            if (!isset($token->usuario_id) || !isset($token->exp) || $token->exp <= time() || !isset($token->init) || time() < $token->init)
                return TokenUserHandler::INVALID_TOKEN;

            $user = User::where('usuario_id', $token->usuario_id)
                ->first();

            if (!isset($user))
                return TokenUserHandler::INVALID_TOKEN;

            $check_token = isset($user->remember_token)? $user->remember_token : '';

            if (!hash_equals($check_token, hash('sha256', $jwt)))
                return TokenUserHandler::INVALID_TOKEN;
        } catch (Exception $e) {
            return TokenUserHandler::INVALID_TOKEN;
        }

        return $user;
    }
}
