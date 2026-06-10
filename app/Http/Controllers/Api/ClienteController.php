<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Cliente::query()->orderBy('id')->get(), 200);
    }

    public function show(int $id): JsonResponse
    {
        $cliente = Cliente::query()->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

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

        $cliente = Cliente::query()->create($validated);

        return response()->json($cliente, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $cliente = Cliente::query()->find($id);

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

        $cliente->update($validated);

        return response()->json($cliente->fresh(), 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $cliente = Cliente::query()->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado'], 200);
    }
}