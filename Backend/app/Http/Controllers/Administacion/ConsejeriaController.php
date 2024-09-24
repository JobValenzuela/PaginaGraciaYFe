<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConsejeriaController extends Controller
{
    // Obtener todas las consejerías
    public function get()
    {
        try {
            return ApiResponse::response(data: DB::select("
                select
                    c.*,
                    m.nombre
                from consejerias c
                join miembros m on m.id_miembro = c.id_miembro
            "));
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Crear una nueva consejería
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date',
                'hora_consejeria' => ['nullable', 'regex:/^[0-9]{1,2}:[0-9]{2}$/'],
                'lugar_consejeria' => 'nullable|string|max:255',
                'id_miembro' => 'required|int|exists:miembros,id_miembro',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            DB::insert("
                INSERT INTO consejerias (descripcion, fecha_inicio, fecha_fin, hora_consejeria, lugar_consejeria, id_miembro, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $request->descripcion,
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->hora_consejeria,
                $request->lugar_consejeria,
                $request->id_miembro,
                now(),  // created_at
                now()   // updated_at
            ]);

            return ApiResponse::response(code: 201, message: "Consejería creada correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Actualizar una consejería existente
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|string|max:255',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date',
                'hora_consejeria' => ['nullable', 'regex:/^[0-9]{1,2}:[0-9]{2}$/'],
                'lugar_consejeria' => 'nullable|string|max:255',
                'id_miembro' => 'required|int|exists:miembros,id_miembro',
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            DB::update('UPDATE consejerias
                SET descripcion = ?,
                    fecha_inicio = ?,
                    fecha_fin = ?,
                    hora_consejeria = ?,
                    lugar_consejeria = ?,
                    id_miembro = ?,
                    updated_at = ?
                WHERE id_consejeria = ?', [
                $request->descripcion,
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->hora_consejeria,
                $request->lugar_consejeria,
                $request->id_miembro,
                now(),
                $id
            ]);

            return ApiResponse::response(code: 200, message: "Consejería actualizada correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Eliminar una consejería
    public function destroy($id)
    {
        try {
            DB::delete("
                DELETE FROM consejerias WHERE id_consejeria = ?
            ", [$id]);
            return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
        } catch (\Exception $e) {
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }
}
