<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CamisetaController extends Controller
{
    #[OA\Get(
        path: '/api/v1/camisetas',
        tags: ['Camisetas'],
        summary: 'Listar camisetas',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Listado obtenido',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(type: 'object'))
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        return response()->json(Camiseta::allRecords(), 200);
    }

    #[OA\Get(
        path: '/api/v1/camisetas/{id}',
        tags: ['Camisetas'],
        summary: 'Obtener camiseta por id',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Camiseta encontrada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrada', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $camiseta = Camiseta::findById($id);

        if (!$camiseta) {
            return response()->json(['message' => 'Camiseta no encontrada'], 404);
        }

        return response()->json($camiseta, 200);
    }

    #[OA\Post(
        path: '/api/v1/camisetas',
        tags: ['Camisetas'],
        summary: 'Crear camiseta',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'codigo_producto'],
                properties: [
                    new OA\Property(property: 'titulo', type: 'string'),
                    new OA\Property(property: 'club', type: 'string'),
                    new OA\Property(property: 'pais', type: 'string'),
                    new OA\Property(property: 'tipo', type: 'string'),
                    new OA\Property(property: 'color', type: 'string'),
                    new OA\Property(property: 'precio', type: 'number', format: 'float'),
                    new OA\Property(property: 'precio_oferta', type: 'number', format: 'float', nullable: true),
                    new OA\Property(property: 'detalles', type: 'string', nullable: true),
                    new OA\Property(property: 'codigo_producto', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Creada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
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

        $camiseta = Camiseta::createRecord($validated);

        return response()->json($camiseta, 201);
    }

    #[OA\Put(
        path: '/api/v1/camisetas/{id}',
        tags: ['Camisetas'],
        summary: 'Actualizar camiseta',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(type: 'object')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Actualizada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrada', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $camiseta = Camiseta::findById($id);

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

        $updated = Camiseta::updateRecord($id, $validated);

        return response()->json($updated, 200);
    }

    #[OA\Delete(
        path: '/api/v1/camisetas/{id}',
        tags: ['Camisetas'],
        summary: 'Eliminar camiseta',
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
        if (!Camiseta::deleteRecord($id)) {
            return response()->json(['message' => 'Camiseta no encontrada'], 404);
        }

        return response()->json(['message' => 'Camiseta eliminada'], 200);
    }
}