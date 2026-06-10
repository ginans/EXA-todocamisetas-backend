<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class ClienteController extends Controller
{
    #[OA\Get(
        path: '/api/v1/clientes',
        tags: ['Clientes'],
        summary: 'Listar clientes',
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
        return response()->json(Cliente::allRecords(), 200);
    }

    #[OA\Get(
        path: '/api/v1/clientes/{id}',
        tags: ['Clientes'],
        summary: 'Obtener cliente por id',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Cliente encontrado', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrado', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $cliente = Cliente::findById($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    #[OA\Post(
        path: '/api/v1/clientes',
        tags: ['Clientes'],
        summary: 'Crear cliente',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nombre_comercial', 'rut', 'direccion', 'categoria', 'contacto_nombre', 'contacto_email'],
                properties: [
                    new OA\Property(property: 'nombre_comercial', type: 'string'),
                    new OA\Property(property: 'rut', type: 'string'),
                    new OA\Property(property: 'direccion', type: 'string'),
                    new OA\Property(property: 'categoria', type: 'string', enum: ['regular', 'preferencial']),
                    new OA\Property(property: 'contacto_nombre', type: 'string'),
                    new OA\Property(property: 'contacto_email', type: 'string', format: 'email'),
                    new OA\Property(property: 'porcentaje_oferta', type: 'number', format: 'float', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Creado', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre_comercial' => ['required', 'string', 'max:255'],
            'rut' => ['required', 'string', 'max:20', 'unique:clientes,rut'],
            'direccion' => ['required', 'string', 'max:255'],
            'categoria' => ['required', Rule::in(['regular', 'preferencial'])],
            'contacto_nombre' => ['required', 'string', 'max:255'],
            'contacto_email' => ['required', 'email', 'max:255'],
            'porcentaje_oferta' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $cliente = Cliente::createRecord($validated);

        return response()->json($cliente, 201);
    }

    #[OA\Put(
        path: '/api/v1/clientes/{id}',
        tags: ['Clientes'],
        summary: 'Actualizar cliente',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(type: 'object')),
        responses: [
            new OA\Response(response: 200, description: 'Actualizado', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrado', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 422, description: 'Validacion', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $cliente = Cliente::findById($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre_comercial' => ['sometimes', 'required', 'string', 'max:255'],
            'rut' => ['sometimes', 'required', 'string', 'max:20', 'unique:clientes,rut,'.$cliente->id],
            'direccion' => ['sometimes', 'required', 'string', 'max:255'],
            'categoria' => ['sometimes', 'required', Rule::in(['regular', 'preferencial'])],
            'contacto_nombre' => ['sometimes', 'required', 'string', 'max:255'],
            'contacto_email' => ['sometimes', 'required', 'email', 'max:255'],
            'porcentaje_oferta' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $updated = Cliente::updateRecord($id, $validated);

        return response()->json($updated, 200);
    }

    #[OA\Delete(
        path: '/api/v1/clientes/{id}',
        tags: ['Clientes'],
        summary: 'Eliminar cliente',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer', minimum: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Eliminado', content: new OA\JsonContent(type: 'object')),
            new OA\Response(response: 404, description: 'No encontrado', content: new OA\JsonContent(type: 'object')),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        if (!Cliente::deleteRecord($id)) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json(['message' => 'Cliente eliminado'], 200);
    }
}