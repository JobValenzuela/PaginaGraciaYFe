<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Visitante;
use Illuminate\Support\Facades\Validator;

class VisitanteController extends Controller
{
    public function get()
    {
        try {
            $data = Visitante::all();
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
                'nombre' => 'required|string|max:100',
                'telefono' => 'required|string|max:20',
                'fecha_visita' => 'required|date',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }
            $visitante = Visitante::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'fecha_visita' => $request->fecha_visita,
                'id_ministerio' => 6,
            ]);

            return ApiResponse::response(code: 201, message: "Visitante registrado correctamente", data: $visitante);
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Actualizar una consejería existente
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                'telefono' => 'required|string|max:20',
                'fecha_visita' => 'required|date',
            ]);


            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }
            $visitante = Visitante::findOrFail($id);

            $visitante->update([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'fecha_visita' => $request->fecha_visita,
                'id_ministerio' => 6,
            ]);

            return ApiResponse::response(code: 201, message: "Visitante actualizado correctamente", data: $visitante);
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Eliminar una consejería
    public function destroy($id)
    {
        try {
           $visitante = Visitante::findOrFail($id);
            $visitante->delete();
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
    public function convertir($id)
    {
        try {
        //    $visitante = Visitante::findOrFail($id);
        //     $visitante->delete();
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
}
