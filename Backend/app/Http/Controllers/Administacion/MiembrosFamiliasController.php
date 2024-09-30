<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MiembrosFamiliasController extends Controller
{
    // Obtener todos los miembros
    public function get($id)
    {
        $existsFamilia = \DB::select('SELECT * FROM familias where id_familia = ?',[$id]);
        if (!$existsFamilia) {
            return ApiResponse::response(message: "La familia seleccionada no existe", code: 400);
        }
        $data = \DB::select("
                SELECT mf.*,m.nombre
                FROM miembros_familia mf
                LEFT JOIN miembros m ON m.id_miembro = mf.id_miembro
                WHERE mf.id_familia = ?;
            ", [$id]);
        return ApiResponse::response(data: $data);
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_familia' => 'required|int|exists:familias,id_familia',
                'id_miembro' => 'required|int|exists:miembros,id_miembro',
                'rol_en_familia' => 'required|string|max:30',
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
            }

            DB::insert("
                        insert into miembros_familia (id_familia, id_miembro, rol_en_familia, created_at, updated_at)
                        values (?, ?, ?, ?, ?)
                        ",
                [$request->id_familia, $request->id_miembro, $request->rol_en_familia, now(), now()]
            );
            return ApiResponse::response(code: 201, message: "Miembro añadido en la familia correctamente");
        } catch (\Exception $e) {
            \Log::debug(json_encode($e->getMessage()));
            return ApiResponse::response(message: $e->getMessage(), code: 500);
        }
    }

    // Eliminar un ministerio
    public function destroy($id)
    {
        \DB::delete("
            DELETE FROM miembros_familia where id_miembro_familia = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
    }
}
