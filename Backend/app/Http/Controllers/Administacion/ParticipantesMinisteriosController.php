<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParticipantesMinisteriosController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        return ApiResponse::response(data: \DB::select("
                        select
                         pm.*,
                         m.nombre as nombre_miembro,
                         m2.nombre as nombre_ministerio
                         from participantes_ministerios pm
                        join miembros m on m.id_miembro = pm.id_miembro
                        join ministerios m2 on m2.id_ministerio = pm.id_ministerio
                    "));
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        $validated = $request->validate([
            'id_ministerio' => 'required|int|exists:ministerios,id_ministerio',
            'id_miembro' => 'required|int|exists:miembros,id_miembro',
        ]);
        $existsParticipante = DB::selectOne("Select * from participantes_ministerios
                                where id_miembro = ? and id_ministerio = ?",[$request->id_miembro,$request->id_ministerio]);
                                \Log::debug(json_encode($existsParticipante));

        if ($existsParticipante) {
            return ApiResponse::response(message: "Este miembro ya pertenece a este ministerio", code: 400);
        }
        $existsLider = DB::selectOne("
                            Select * from lideres_ministerios lm
                            where lm.id_miembro = ?
                            and lm.fecha_termino is null
                            and id_ministerio = ?
                            ",[$request->id_miembro,$request->id_ministerio]);
        if ($existsLider) {
            return ApiResponse::response('Error', code: 400, message: 'Este miembro es lider de este ministerio');
        }
        DB::insert("
                    insert into participantes_ministerios (id_miembro, id_ministerio, created_at)
                    values (?, ?, ?)
                    ",
            [
                $request->id_miembro,
                $request->id_ministerio,
                now()
            ]
        );
        return ApiResponse::response(code: 201, message: "Miembro añadido correctamente al ministerio");
    }

    // Eliminar un ministerio
    public function destroy($id)
    {
        DB::delete("
            DELETE FROM participantes_ministerios where id_participante_ministerio = ?
            ", [$id]);
        return ApiResponse::response(code: 204, message: 'Miembro eliminado correctamente del ministerio');
    }
}
