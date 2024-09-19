<?php
namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventosController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select e.*,m.nombre from eventos e
                        join miembros m on m.id_miembro = e.id_miembro_encargado
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^[0-9]{1,2}:[0-9]{2}$/'],
            'lugar' => 'required|string|max:255',
            'publicidad' => 'required|string',
            'costo' => 'nullable|numeric',
            'id_miembro_encargado' => 'nullable|int|exists:miembros,id_miembro',
        ]);
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }


        DB::insert("
                insert into eventos (nombre, descripcion, fecha, hora, lugar, publicidad, costo, id_miembro_encargado, created_at, updated_at)
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ",
            [
                $request->nombre,
                $request->descripcion,
                $request->fecha,
                $request->hora,
                $request->lugar,
                $request->publicidad,
                $request->costo,
                $request->id_miembro_encargado,
                now(),  // created_at
                now()   // updated_at
            ]
        );

        return ApiResponse::response(code: 201, message: "Evento creado correctamente");
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        // Crear el validador usando Validator::make
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^[0-9]{1,2}:[0-9]{2}$/'],
            'lugar' => 'required|string|max:255',
            'publicidad' => 'required|string',
            'costo' => 'nullable|numeric',
            'id_miembro_encargado' => 'nullable|int|exists:miembros,id_miembro',
        ]);
        if ($validator->fails()) {
            return ApiResponse::response(message: $validator->errors()->first(), code: 400); // Usar 400 para errores de validación
        }

        // Ejecutar la consulta de actualización en la base de datos
        \DB::update('UPDATE eventos
                SET nombre = ?,
                    descripcion = ?,
                    fecha = ?,
                    hora = ?,
                    lugar = ?,
                    publicidad = ?,
                    costo = ?,
                    id_miembro_encargado = ?,
                    updated_at = ?
                WHERE id_evento = ?', [
            $request->nombre,
            $request->descripcion,
            $request->fecha,
            $request->hora,
            $request->lugar,
            $request->publicidad,
            $request->costo,
            $request->id_miembro_encargado,
            now(),
            $id
        ]);

        // Devolver una respuesta exitosa
        return ApiResponse::response(message: 'Evento actualizado con éxito', code: 200);
    }


    // Eliminar un ministerio
    public function destroy($id)
    {
        \DB::delete("
            DELETE FROM eventos where id_envento = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Eliminado correctamente');
    }
}
