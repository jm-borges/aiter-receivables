<?php

namespace App\Http\Controllers\Core\Pivots;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationHasReceivables\GetOperationHasReceivablesRequest;
use App\Http\Requests\OperationHasReceivables\StoreOperationHasReceivableRequest;
use App\Http\Requests\OperationHasReceivables\UpdateOperationHasReceivableRequest;
use App\Http\Resources\OperationHasReceivableResource;
use App\Models\Core\Pivots\OperationHasReceivable;
use App\Services\Core\Pivots\OperationHasReceivableService;
use Illuminate\Http\JsonResponse;

class OperationHasReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetOperationHasReceivablesRequest $request, OperationHasReceivableService $operationHasReceivableService): JsonResponse
    {
        $query = $operationHasReceivableService->filter($request);

        $operationHasReceivables = $query->get();

        return response()->json(['data' => OperationHasReceivableResource::collection($operationHasReceivables)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperationHasReceivableRequest $request, OperationHasReceivableService $operationHasReceivableService): JsonResponse
    {
        $operationHasReceivable = $operationHasReceivableService->create($request);

        return response()->json(['data' => OperationHasReceivableResource::make($operationHasReceivable), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(OperationHasReceivable $operationHasReceivable): JsonResponse
    {
        return response()->json(OperationHasReceivableResource::make($operationHasReceivable));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperationHasReceivableRequest $request, OperationHasReceivable $operationHasReceivable, OperationHasReceivableService $operationHasReceivableService): JsonResponse
    {
        $operationHasReceivable = $operationHasReceivableService->update($operationHasReceivable, $request);

        return response()->json(['data' => OperationHasReceivableResource::make($operationHasReceivable), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperationHasReceivable $operationHasReceivable): JsonResponse
    {
        $operationHasReceivable->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
