<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Planta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlantasController extends Controller
{
    /**
     * Mostrar una lista de todas las plantas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $plantas = Planta::all();

        return response()->json(['plantas' => $plantas], 200);
    }

    /**
     * Mostrar los detalles de una planta específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $planta = Planta::find($id);

        if (!$planta) {
            return response()->json(['message' => 'Planta no encontrada'], 404);
        }

        return response()->json(['planta' => $planta], 200);
    }

    /**
     * Crear una nueva planta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SKU' => 'required|unique:plantas',
            'nombre' => 'nullable',
            'tipo_planta' => 'nullable',
            'descripcion' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_categoria' => 'nullable|exists:categorias,id',
            'cuidados' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $planta = new Planta($request->all());

        // Manejar la subida de la imagen si está presente
        if ($request->hasFile('foto')) {
            $imagePath = $planta->storeImage($request->file('foto'));
        }

        $planta->save();

        return response()->json(['planta' => $planta], 201);
    }

    /**
     * Actualizar los detalles de una planta específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $planta = Planta::find($id);

        if (!$planta) {
            return response()->json(['message' => 'Planta no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'SKU' => 'required|unique:plantas,SKU,' . $id,
            'nombre' => 'nullable',
            'tipo_planta' => 'nullable',
            'descripcion' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_categoria' => 'nullable|exists:categorias,id',
            'cuidados' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Actualizar la planta con los nuevos datos
        $planta->update($request->all());

        // Manejar la subida de la nueva imagen si está presente
        if ($request->hasFile('foto')) {
            $imagePath = $planta->storeImage($request->file('foto'));
        }

        return response()->json(['planta' => $planta], 200);
    }

    /**
     * Eliminar una planta específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $planta = Planta::find($id);

        if (!$planta) {
            return response()->json(['message' => 'Planta no encontrada'], 404);
        }

        // Eliminar la imagen asociada, si existe
        if ($planta->foto_path) {
            Storage::delete('public/' . $planta->foto_path);
        }

        $planta->delete();

        return response()->json(['message' => 'Planta eliminada con éxito'], 200);
    }
}
