<?php
namespace App\Http\Controllers;

use App\Models\Ministerio;
use Illuminate\Http\Request;

class MinisterioController extends Controller
{
    // Obtener todos los ministerios
    public function index()
    {
        return \DB::select("
            select * from ministerios
        ");
    }

    // Crear un nuevo ministerio
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ministerio = Ministerio::create($validated);
        return response()->json($ministerio, 201);
    }

    // Obtener un ministerio por ID
    public function show($id)
    {
        $ministerio = Ministerio::findOrFail($id);
        return response()->json($ministerio);
    }

    // Actualizar un ministerio existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:60',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ministerio = Ministerio::findOrFail($id);
        $ministerio->update($validated);
        return response()->json($ministerio);
    }

    // Eliminar un ministerio
    public function destroy($id)
    {
        $ministerio = Ministerio::findOrFail($id);
        $ministerio->delete();
        return response()->json(null, 204);
    }
}
