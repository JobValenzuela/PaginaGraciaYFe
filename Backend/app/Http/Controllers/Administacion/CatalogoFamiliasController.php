<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Familia;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CatalogoFamiliasController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        try {
            return ApiResponse::response(data: Familia::all());
        } catch (\Exception $e) {
            return ApiResponse::response('Error', 500, [], $e->getMessage());
        }
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_familia' => 'required|string|max:60|unique:familias,nombre_familia',
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            Familia::create([
                'nombre_familia' => $request->nombre_familia
            ]);

            return ApiResponse::response(code: 201, message: "Familia creada correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response('Error', 500, [], $e->getMessage());
        }
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_familia' => 'required|string|max:60|unique:familias,nombre_familia',
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }
            $familia = Familia::findOrFail($id);
            $familia->update([
                'nombre_familia' => $request->nombre_familia
            ]);

            return ApiResponse::response(code: 201, message: "Familia actualizada correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response('Error', 500, [], $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $existsMiembrosFamilia = \DB::select("SELECT * FROM miembros_familia where id_familia = ?", [$id]);
            if ($existsMiembrosFamilia) {
                return ApiResponse::response(code: 400, message: 'No puedes eliminar esta familia');
            }
            $familia = Familia::findOrFail($id);
            $familia->delete();
            return ApiResponse::response(code: 204, message: 'Eliminada correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response('Error', 500, [], $e->getMessage());
        }
    }
}
