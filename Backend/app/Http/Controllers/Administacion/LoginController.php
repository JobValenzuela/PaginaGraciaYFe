<?php

namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiResponse;
use App\Http\Helpers\TokenUserHandler;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
     * Método principal para realizar la acción del login, se encarga de recibir el usuario y la contraseña, verifica si el usuario es correcto
     * y retorna el token, junto con el nombre de usuario, su id y si es administrador o no, este método funciona para las 2 partes, el login de
     * usuario y administrador
     */
    public function login(Request $request)
    {
        $params = json_decode($request->getContent());

        if (empty($params))
            return ApiResponse::response(status: 'error', code: 400, message: 'No json');

        $validator = Validator::make((array) $params, [
            'usuario' => 'required|string|max:255',
            'password' => 'required|string|max:128'
        ]);

        if ($validator->fails())
            return ApiResponse::response(status: 'error', code: 400, message: json_encode($validator->errors()));

        try {
            //se busca en la db el usuario por medio del nombre de usuario
            $user = User::where('nombre_usuario', $params->usuario)
                ->first();
            // si no existe el usuario o está inactivo, o su contraseña es incorrecta
            if (!$user || !password_verify($params->password, $user->password))
                return ApiResponse::response(status: 'error', code: 400, message: 'Usuario no encontrado');

            // si todo sale bien, se crea un token nuevo para el usuario
            $token = TokenUserHandler::encode($user);

            // Actualizamos el token
            $user->update(['remember_token' => hash('sha256', $token)]);

            // Formateamos los datos de salida
            $data = [
                'token' => $token,
                'nombre_usuario' => $user->nombre_usuario,
                'id_usuario' => $user->usuario_id,
                'tipo_usuario' => strtolower($user->tipo_usuario),
            ];

            return ApiResponse::response(data: $data);
        } catch (Exception $e) {
            return ApiResponse::response(status: 'error', code: 500, message: $e->getMessage());
        }
    }
}
