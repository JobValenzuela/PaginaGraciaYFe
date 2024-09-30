<?php
namespace App\Http\Controllers\Administacion;

use App\Http\Controllers\Controller;

use App\Http\Helpers\ApiResponse;
use App\Models\IngresosEgresos;
use App\Models\Ministerio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IngresosEgresosController extends Controller
{
    // Obtener todos los ministerios
    public function get()
    {
        try {
            $data = IngresosEgresos::all();
            return ApiResponse::response( data: $data );
        } catch (\Exception $e) {
            return ApiResponse::response('Error',500,[],$e->getMessage());
        }
    }

    // Crear un nuevo ministerio
    public function post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo' => 'required|string|in:I,E',
                'concepto' => 'required|string|max:100',
                'cantidad' => 'required|numeric|min:1',
                'descripcion' => 'nullable|string|max:255',
                'fecha' => 'required|date'
            ]);
            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400);
            }


            $ingresoegreso = IngresosEgresos::create([
                'tipo' => $request->tipo,
                'concepto' => $request->concepto,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha
            ]);

            return ApiResponse::response(code: 201, message: "Ingreso o egreso creado correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response('Error',500,[],$e->getMessage());
        }
    }

    // Obtener un ministerio por ID

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'tipo' => 'required|string|in:I,E',
                'concepto' => 'required|string|max:100',
                'cantidad' => 'required|numeric|min:1',
                'descripcion' => 'nullable|string|max:255',
                'fecha' => 'required|date'
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(message: $validator->errors()->first(), code: 400);
            }

            $ingresoegreso = IngresosEgresos::find($id);

            $ingresoegreso->update([
                'tipo' => $request->tipo,
                'concepto' => $request->concepto,
                'cantidad' => $request->cantidad,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha
            ]);

            return ApiResponse::response(code: 201, message: "Ingreso o egreso creado correctamente");
        } catch (\Exception $e) {
            return ApiResponse::response('Error',500,[],$e->getMessage());
        }
        // Crear el validador usando Validator::make
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
