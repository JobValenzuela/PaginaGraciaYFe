<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function get()
    {
        try {
            $data = Rol::all();
            return ApiResponse::response(data: $data);
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Crear una nueva consejería
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_rol' => 'required|string|max:100|unique:roles,nombre_rol'
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            $usuario = Rol::create([
                'nombre_rol' => $request->nombre_rol
            ]);

            return ApiResponse::response(code: 201, message: "Rol creado correctamente", data:$usuario);
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Actualizar una consejería existente
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_usuario' => 'required|string|max:30|unique:usuarios,nombre_usuario,'.$id,
                'password' => 'required|string|max:30',
                'id_rol' => 'required|int|exists:roles,id_rol',
                'id_miembro' => 'required|int|exists:id_miembro',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }
            $usuario = User::findOrFail($id);

            $usuario->update([
                'nombre_usuario' => $request->nombre_usuario,
                'password' => $request->password,
                'id_rol' =>  $request->id_rol,
                'id_miembro' => $request->id_miembro,
            ]);

            return ApiResponse::response(code: 201, message: "Usuario creado correctamente", data: $usuario);
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Eliminar una consejería
    public function destroy($id)
    {
        try {
           $user = User::findOrFail($id);
            $user->delete();
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
}
