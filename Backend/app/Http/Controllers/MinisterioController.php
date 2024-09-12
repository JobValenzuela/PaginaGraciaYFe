<?php
namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MinisterioController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select * from ministerios
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:255',
        ]);

        DB::insert("
                    insert into ministerios (nombre, descripcion, created_at, updated_at)
                    values (?, ?, ?, ?)
                    ",
            [$request->nombre, $request->descripcion, now(), now()]
        );
        return ApiResponse::response(code: 201, message: "Ministerio creado correctamente");
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Crear el validador usando Validator::make
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Verificar si el validador falla
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        // Ejecutar la consulta de actualización en la base de datos
        \DB::update('UPDATE ministerios SET nombre = ?, descripcion = ?, updated_at = ? WHERE id_ministerio = ?', [
            $request->nombre,
            $request->descripcion,
            now(),
            $id
        ]);

        // Devolver una respuesta exitosa
        return ApiResponse::response(message: 'Ministerio actualizado con éxito', code: 200);
    }


    // Eliminar un ministerio
    public function destroy($id)
    {
        \DB::delete("
            DELETE FROM ministerios where id_ministerio = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
    }
}
