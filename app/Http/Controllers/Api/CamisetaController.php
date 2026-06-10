<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CamisetaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Camiseta::query()->orderBy('id')->get(), 200);
    }

    public function show(int $id): JsonResponse
    {
        $camiseta = Camiseta::query()->find($id);

        if (!$camiseta) {
            return response()->json(['message' => 'Camiseta no encontrada'], 404);
        }

        return response()->json($camiseta, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'club' => ['required', 'string', 'max:255'],
            'pais' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0'],
            'detalles' => ['nullable', 'string'],
            'codigo_producto' => ['required', 'string', 'max:255', 'unique:camisetas,codigo_producto'],
        ]);

        $camiseta = Camiseta::query()->create($validated);

        return response()->json($camiseta, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $camiseta = Camiseta::query()->find($id);

        if (!$camiseta) {
            return response()->json(['message' => 'Camiseta no encontrada'], 404);
        }

        $validated = $request->validate([
            'titulo' => ['sometimes', 'required', 'string', 'max:255'],
            'club' => ['sometimes', 'required', 'string', 'max:255'],
            'pais' => ['sometimes', 'required', 'string', 'max:255'],
            'tipo' => ['sometimes', 'required', 'string', 'max:255'],
            'color' => ['sometimes', 'required', 'string', 'max:255'],
            'precio' => ['sometimes', 'required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0'],
            'detalles' => ['nullable', 'string'],
            'codigo_producto' => ['sometimes', 'required', 'string', 'max:255', 'unique:camisetas,codigo_producto,'.$camiseta->id],
        ]);

        $camiseta->update($validated);

        return response()->json($camiseta->fresh(), 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $camiseta = Camiseta::query()->find($id);

        if (!$camiseta) {
            return response()->json(['message' => 'Camiseta no encontrada'], 404);
        }

        $camiseta->delete();

        return response()->json(['message' => 'Camiseta eliminada'], 200);
    }
}