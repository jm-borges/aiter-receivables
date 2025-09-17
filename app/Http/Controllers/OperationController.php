<?php

namespace App\Http\Controllers;

use App\Http\Requests\Operations\GetOperationsRequest;
use App\Http\Requests\Operations\StoreOperationRequest;
use App\Http\Requests\Operations\UpdateOperationRequest;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Services\OperationService;
use Illuminate\Http\JsonResponse;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetOperationsRequest $request, OperationService $operationService): JsonResponse
    {
        $query = $operationService->filter($request);

        $operations = $query->get();

        return response()->json(['data' => OperationResource::collection($operations)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperationRequest $request, OperationService $operationService): JsonResponse
    {
        $operation = $operationService->create($request);

        return response()->json(['data' => OperationResource::make($operation), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Operation $operation): JsonResponse
    {
        return response()->json(OperationResource::make($operation));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperationRequest $request, Operation $operation, OperationService $operationService): JsonResponse
    {
        $operation = $operationService->update($operation, $request);

        return response()->json(['data' => OperationResource::make($operation), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation): JsonResponse
    {
        $operation->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}