<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CatalogoFamiliasController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select * from familias
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_familia' => 'required|string|max:60|unique:familias,nombre_familia',
        ]);
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        DB::insert("
                    insert into familias (nombre_familia, created_at, updated_at)
                    values (?, ?, ?)
                    ",
            [$request->nombre_familia, now(), now()]
        );
        return ApiResponse::response(code: 201, message: "Familia creada correctamente");
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $validator = Validator::make($request->all(), [
            'nombre_familia' => 'required|string|max:60|unique:familias,nombre_familia,' . $id . ',id_familia',
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400);
        }

        // Comprobar si la familia existe
        $exists = \DB::table('familias')->where('id_familia', $id)->exists();

        if (!$exists) {
            return ApiResponse::response(message: 'La familia seleccionada no existe', code: 404);
        }

        // Actualizar los datos en la base de datos
        \DB::table('familias')
            ->where('id_familia', $id)
            ->update([
                'nombre_familia' => $request->nombre_familia,
                'updated_at' => now(),
            ]);

        // Devolver una respuesta exitosa
        return ApiResponse::response(message: 'Familia actualizada con éxito', code: 200);
    }




    // Eliminar un ministerio
    public function destroy($id)
    {
        $existsMiembrosFamilia = \DB::select("SELECT * FROM miembros_familia where id_familia = ?", [$id]);
        if ($existsMiembrosFamilia) {
            return ApiResponse::response(code: 400, message: 'No puedes eliminar esta familia');
        }
        \DB::delete("
            DELETE FROM familias where id_familia = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminada correctamente');
    }
}
