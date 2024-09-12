<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

/*
* Clase utilizada para manejar los responses de cada uno de los controladores de la aplicación
*/
class ApiResponse
{
    /*
    * Response general
    */
    public static function response($status = 'success', $code = 200, $data = [], $message = '') : JsonResponse
    {
        return response()->json([
            'status' => $status,
            'dataset' => $data,
            'message' => $message
        ], $code);
    }
}
