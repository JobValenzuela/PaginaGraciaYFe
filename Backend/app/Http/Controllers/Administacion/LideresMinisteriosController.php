<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;

use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LideresMinisteriosController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select lm.*,m.nombre as nombre_miembro,m.celular,mi.nombre as nombre_ministerio from lideres_ministerios lm
                        join miembros m on m.id_miembro = lm.id_miembro
                        join ministerios mi on mi.id_ministerio = lm.id_ministerio
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_miembro' => 'required|int|exists:miembros,id_miembro',
            'id_ministerio' => 'required|int|exists:ministerios,id_ministerio',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        DB::insert("
            INSERT INTO lideres_ministerios (id_miembro, id_ministerio, fecha_inicio, fecha_termino, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ", [
            $request->id_miembro,
            $request->id_ministerio,
            $request->fecha_inicio,
            $request->fecha_termino,
            now(),
            now()
        ]);


        return ApiResponse::response(code: 201, message: "Lider insertado correctamente");
    }


    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Validar la entrada usando Validator::make
        $validator = Validator::make($request->all(), [
            'id_miembro' => 'required|int|exists:miembros,id_miembro',
            'id_ministerio' => 'required|int|exists:ministerios,id_ministerio',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'nullable|date',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // 400 para errores de validación
        }

        // Ejecutar la consulta de actualización en la base de datos
        \DB::update("
        UPDATE lideres_ministerios SET
            id_miembro = ?,
            id_ministerio = ?,
            fecha_inicio = ?,
            fecha_termino = ?,
            updated_at = ?
        WHERE id_lider = ?
    ", [
            $request->id_miembro,
            $request->id_ministerio,
            $request->fecha_inicio,
            $request->fecha_termino,
            now(),
            $id
        ]);

        // Devolver una respuesta exitosa
        return ApiResponse::response(message: 'Líder de ministerio actualizado con éxito', code: 200);
    }



    // Eliminar un ministerio
    public function destroy($id)
    {
        \DB::delete("
            DELETE FROM lideres_ministerios where id_lider = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
    }
}
