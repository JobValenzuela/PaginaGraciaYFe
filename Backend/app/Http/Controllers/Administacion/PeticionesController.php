<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Peticion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PeticionesController extends Controller
{
    public function get()
    {
        try {
            $data = Peticion::all()->where('listo',0);
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
                'nombre_completo' => 'required|string|max:255',
                'telefono' => 'required|string|max:20|min:10',
                'descripcion_peticion' => 'required|string',
                'fecha_peticion' => 'required|date',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

             $peticion = Peticion::create([
                'nombre_completo' => $request->nombre_completo,
                'telefono' => $request->telefono,
                'descripcion_peticion' => $request->descripcion_peticion,
                'fecha_peticion' => $request->fecha_peticion,
                'id_ministerio' => 7,
            ]);

            return ApiResponse::response(code: 201, message: "Peticion creada correctamente", data: $peticion);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Actualizar una consejería existente
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_completo' => 'required|string|max:255',
                'telefono' => 'required|string|max:20|min:10',
                'descripcion_peticion' => 'required|string',
                'fecha_peticion' => 'required|date',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }
            $peticion = Peticion::findOrFail($id);
             $peticion->update([
                'nombre_completo' => $request->nombre_completo,
                'telefono' => $request->telefono,
                'descripcion_peticion' => $request->descripcion_peticion,
                'fecha_peticion' => $request->fecha_peticion,
                'id_ministerio' => 7,
            ]);

            return ApiResponse::response(code: 201, message: "Peticion actualizada correctamente", data: $peticion);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Eliminar una consejería
    public function destroy($id)
    {
        try {
           $peticion = Peticion::findOrFail($id);
            $peticion->listo = 1;
            $peticion->update();
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
}
