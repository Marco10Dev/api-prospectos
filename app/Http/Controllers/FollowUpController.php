<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Http\Requests\StoreFollowUpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FollowUpController extends Controller
{
    public function store(StoreFollowUpRequest $request, Prospect $prospect): JsonResponse
    {
        // Rechazar si está cerrado (409 Conflict)
        if ($prospect->status === 'closed') {
            return response()->json(['message' => 'Un prospecto cerrado no puede recibir seguimientos'], 409);
        }

        $followUp = DB::transaction(function () use ($request, $prospect) {
            $followUp = $prospect->followUps()->create($request->validated());

            if ($prospect->status === 'new') {
                $prospect->status = 'contacted';
                $prospect->save();
            }

            return $followUp;
        });

        return response()->json($followUp, 201);
    }
}



