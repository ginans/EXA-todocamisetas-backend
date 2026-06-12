<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Talla;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class TallaController extends Controller
{
    #[OA\Get(
        path: '/api/v1/tallas',
        tags: ['Tallas'],
        summary: 'Listar tallas',
        responses: [
            new OA\Response(response: 200, description: 'Listado obtenido', content: new OA\JsonContent(type: 'array', items: new OA\Items(type: 'object'))),
        ]
    )]
    public function index(): JsonResponse
    {
        return response()->json(Talla::allRecords(), 200);
    }

    #[OA\Get(
        path: '/api/v1/tallas/{id}',
        tags: ['Tallas'],
        summary: 'Obtener talla por id',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Talla encontrada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrada', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $talla = Talla::findById($id);

        if (!$talla) {
            return response()->json(['message' => 'Talla no encontrada'], 404);
        }

        return response()->json($talla, 200);
    }

    #[OA\Post(
        path: '/api/v1/tallas',
        tags: ['Tallas'],
        summary: 'Crear talla',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(type: 'object')),
        responses: [
            new OA\Response(response: 201, description: 'Creada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:20', 'unique:tallas,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $talla = Talla::createRecord($validated);

        return response()->json($talla, 201);
    }

    #[OA\Put(
        path: '/api/v1/tallas/{id}',
        tags: ['Tallas'],
        summary: 'Actualizar talla',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(type: 'object')),
        responses: [
            new OA\Response(response: 200, description: 'Actualizada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $talla = Talla::findById($id);

        if (!$talla) {
            return response()->json(['message' => 'Talla no encontrada'], 404);
        }

        $validated = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:20', 'unique:tallas,nombre,'.$talla->id],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        $updated = Talla::updateRecord($id, $validated);

        return response()->json($updated, 200);
    }

    #[OA\Delete(
        path: '/api/v1/tallas/{id}',
        tags: ['Tallas'],
        summary: 'Eliminar talla',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrada', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        if (!Talla::deleteRecord($id)) {
            return response()->json(['message' => 'Talla no encontrada'], 404);
        }

        return response()->json(['message' => 'Talla eliminada'], 200);
    }
}