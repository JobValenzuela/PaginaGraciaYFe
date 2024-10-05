<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;

use App\Http\Helpers\ApiResponse;
use App\Models\Mobiliario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MobiliarioController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        try {
            return ApiResponse::response(data: Mobiliario::all());
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:50|Unique:mobiliario,nombre',
                'cantidad' => 'required|numeric',
                'descripcion' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }


            Mobiliario::create([
                'nombre' => $request->nombre,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'id_miembro_encargado' => 2, // Cambiar a un campo configurable y sacarlo de la bd
            ]);

            return ApiResponse::response(code: 201, message: "Registro creado correctamente en el mobiliario");
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Crear el validador usando Validator::make
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:50|Unique:mobiliario,nombre,'.$id.',id_mobiliario',
                'cantidad' => 'required|numeric',
                'descripcion' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            $mobiliario = Mobiliario::find($id);
            $mobiliario->update([
                'nombre' => $request->nombre,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'id_miembro_encargado' => 2, // Cambiar a un campo configurable y sacarlo de la bd
            ]);

            return ApiResponse::response(code: 201, message: "Registro actualizado correctamente en el mobiliario");
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }


    // Eliminar un ministerio
    public function destroy($id)
    {
        try {
           $mobiliario = Mobiliario::findOrFail($id);
            $mobiliario->delete();
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
}
