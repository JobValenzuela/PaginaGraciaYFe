<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;

use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MiembrosController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select * from miembros
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:80',
            'celular' => 'required|string|max:15',
            'calle' => 'required|string|max:100',
            'colonia' => 'required|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_llego' => 'required|date',
            'fecha_membresia' => 'required|date',
            'fecha_bautizmo' => 'nullable|date',
            'fecha_bautizmo_agua' => 'nullable|date',
            'fecha_bautizmo_espiritu_santo' => 'nullable|date',
            'etapa_discipulado_juan' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_juan' => 'nullable|date',
            'fecha_fin_dicipulado_juan' => 'nullable|date',
            'etapa_discipulado_hacia_la_meta_1' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_hacia_la_meta_1' => 'nullable|date',
            'fecha_fin_dicipulado_hacia_la_meta_1' => 'nullable|date',
            'etapa_discipulado_hacia_la_meta_2' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_hacia_la_meta_2' => 'nullable|date',
            'fecha_fin_dicipulado_hacia_la_meta_2' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        DB::insert("
                    insert into miembros (nombre, celular, calle, colonia, fecha_nacimiento, fecha_llego, fecha_membresia, fecha_bautizmo, fecha_bautizmo_agua, fecha_bautizmo_espiritu_santo, etapa_discipulado_juan, fecha_inicio_dicipulado_juan, fecha_fin_dicipulado_juan, etapa_discipulado_hacia_la_meta_1, fecha_inicio_dicipulado_hacia_la_meta_1, fecha_fin_dicipulado_hacia_la_meta_1, etapa_discipulado_hacia_la_meta_2, fecha_inicio_dicipulado_hacia_la_meta_2, fecha_fin_dicipulado_hacia_la_meta_2, created_at, updated_at)
                    values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ",
            [
                $request->nombre,
                $request->celular,
                $request->calle,
                $request->colonia,
                $request->fecha_nacimiento,
                $request->fecha_llego,
                $request->fecha_membresia,
                $request->fecha_bautizmo,
                $request->fecha_bautizmo_agua,
                $request->fecha_bautizmo_espiritu_santo,
                $request->etapa_discipulado_juan,
                $request->fecha_inicio_dicipulado_juan,
                $request->fecha_fin_dicipulado_juan,
                $request->etapa_discipulado_hacia_la_meta_1,
                $request->fecha_inicio_dicipulado_hacia_la_meta_1,
                $request->fecha_fin_dicipulado_hacia_la_meta_1,
                $request->etapa_discipulado_hacia_la_meta_2,
                $request->fecha_inicio_dicipulado_hacia_la_meta_2,
                $request->fecha_fin_dicipulado_hacia_la_meta_2,
                now(),
                now()
            ]
        );

        return ApiResponse::response(code: 201, message: "Miembro creado correctamente");
    }


    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Crear el validador usando Validator::make
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:80',
            'celular' => 'required|string|max:15',
            'calle' => 'required|string|max:100',
            'colonia' => 'required|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_llego' => 'required|date',
            'fecha_membresia' => 'required|date',
            'fecha_bautizmo' => 'nullable|date',
            'fecha_bautizmo_agua' => 'nullable|date',
            'fecha_bautizmo_espiritu_santo' => 'nullable|date',
            'etapa_discipulado_juan' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_juan' => 'nullable|date',
            'fecha_fin_dicipulado_juan' => 'nullable|date',
            'etapa_discipulado_hacia_la_meta_1' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_hacia_la_meta_1' => 'nullable|date',
            'fecha_fin_dicipulado_hacia_la_meta_1' => 'nullable|date',
            'etapa_discipulado_hacia_la_meta_2' => 'nullable|string|max:1',
            'fecha_inicio_dicipulado_hacia_la_meta_2' => 'nullable|date',
            'fecha_fin_dicipulado_hacia_la_meta_2' => 'nullable|date',
        ]);

        // Verificar si el validador falla
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        // Ejecutar la consulta de actualización en la base de datos
        \DB::update("
        UPDATE miembros SET
            nombre = ?, celular = ?, calle = ?, colonia = ?,
            fecha_nacimiento = ?, fecha_llego = ?, fecha_membresia = ?,
            fecha_bautizmo = ?, fecha_bautizmo_agua = ?, fecha_bautizmo_espiritu_santo = ?,
            etapa_discipulado_juan = ?, fecha_inicio_dicipulado_juan = ?, fecha_fin_dicipulado_juan = ?,
            etapa_discipulado_hacia_la_meta_1 = ?, fecha_inicio_dicipulado_hacia_la_meta_1 = ?, fecha_fin_dicipulado_hacia_la_meta_1 = ?,
            etapa_discipulado_hacia_la_meta_2 = ?, fecha_inicio_dicipulado_hacia_la_meta_2 = ?, fecha_fin_dicipulado_hacia_la_meta_2 = ?,
            updated_at = ?
        WHERE id_miembro = ?
    ", [
            $request->nombre,
            $request->celular,
            $request->calle,
            $request->colonia,
            $request->fecha_nacimiento,
            $request->fecha_llego,
            $request->fecha_membresia,
            $request->fecha_bautizmo,
            $request->fecha_bautizmo_agua,
            $request->fecha_bautizmo_espiritu_santo,
            $request->etapa_discipulado_juan,
            $request->fecha_inicio_dicipulado_juan,
            $request->fecha_fin_dicipulado_juan,
            $request->etapa_discipulado_hacia_la_meta_1,
            $request->fecha_inicio_dicipulado_hacia_la_meta_1,
            $request->fecha_fin_dicipulado_hacia_la_meta_1,
            $request->etapa_discipulado_hacia_la_meta_2,
            $request->fecha_inicio_dicipulado_hacia_la_meta_2,
            $request->fecha_fin_dicipulado_hacia_la_meta_2,
            now(),
            $id
        ]);

        // Devolver una respuesta exitosa
        return ApiResponse::response(message: 'Miembro actualizado con éxito', code: 200);
    }



    // Eliminar un ministerio
    public function destroy($id)
    {
        \DB::delete("
            DELETE FROM miembros where id_miembro = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
    }
}
