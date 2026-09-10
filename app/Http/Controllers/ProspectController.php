<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Http\Requests\StoreProspectRequest;
use App\Http\Requests\UpdateProspectRequest;
use Illuminate\Http\JsonResponse;

class ProspectController extends Controller
{
    //listar a los prospectos
    public function index(): JsonResponse
    {
        $prospects = Prospect::with('followUps')->get();
        return response()->json($prospects, 200);
    }

    // crear nuevo prospecto
public function store(StoreProspectRequest $request): JsonResponse
{
    $data = $request->validated();
    $data['status'] = $data['status'] ?? 'new';

    $prospect = Prospect::create($data);

    return response()->json($prospect, 201);
}

    //consultamos detalle del prospecto
    public function show(Prospect $prospect): JsonResponse
    {
        return response()->json($prospect->load('followUps'), 200);
    }

    //regla 1 y 3: editar datos generales, bloqueando si esta cerrando 409 sin modificar el status
    public function update(UpdateProspectRequest $request, Prospect $prospect): JsonResponse
    {
        //regla 3
        if ($prospect->status === 'closed') {
            return response()->json(['message' => 'Un prospecto cerrado no puede editarse'], 409);
        }

        //regla 1
        $prospect->update($request ->validated());
        return response()->json($prospect,200);

    }

    //regla 3 cerrar un prospecto, bloqueando si esta cerrado 409
    public function close(Prospect $prospect): JsonResponse
    {
        $prospect->status = 'closed';
        $prospect->save();
        return response()->json($prospect, 200);
    }

}
