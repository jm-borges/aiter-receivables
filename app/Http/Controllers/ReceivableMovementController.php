<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceivableMovements\GetReceivableMovementsRequest;
use App\Http\Requests\ReceivableMovements\StoreReceivableMovementRequest;
use App\Http\Requests\ReceivableMovements\UpdateReceivableMovementRequest;
use App\Http\Resources\ReceivableMovementResource;
use App\Models\ReceivableMovement;
use App\Services\ReceivableMovementService;
use Illuminate\Http\JsonResponse;

class ReceivableMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetReceivableMovementsRequest $request, ReceivableMovementService $receivableMovementService): JsonResponse
    {
        $query = $receivableMovementService->filter($request);

        $receivableMovements = $query->get();

        return response()->json(['data' => ReceivableMovementResource::collection($receivableMovements)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceivableMovementRequest $request, ReceivableMovementService $receivableMovementService): JsonResponse
    {
        $receivableMovement = $receivableMovementService->create($request);

        return response()->json(['data' => ReceivableMovementResource::make($receivableMovement), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReceivableMovement $receivableMovement): JsonResponse
    {
        return response()->json(ReceivableMovementResource::make($receivableMovement));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceivableMovementRequest $request, ReceivableMovement $receivableMovement, ReceivableMovementService $receivableMovementService): JsonResponse
    {
        $receivableMovement = $receivableMovementService->update($receivableMovement, $request);

        return response()->json(['data' => ReceivableMovementResource::make($receivableMovement), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivableMovement $receivableMovement): JsonResponse
    {
        $receivableMovement->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}