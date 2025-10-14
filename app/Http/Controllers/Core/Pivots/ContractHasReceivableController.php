<?php

namespace App\Http\Controllers\Core\Pivots;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractHasReceivables\GetContractHasReceivablesRequest;
use App\Http\Requests\ContractHasReceivables\StoreContractHasReceivableRequest;
use App\Http\Requests\ContractHasReceivables\UpdateContractHasReceivableRequest;
use App\Http\Resources\ContractHasReceivableResource;
use App\Models\Core\Pivots\ContractHasReceivable;
use App\Services\Core\Pivots\ContractHasReceivableService;
use Illuminate\Http\JsonResponse;

class ContractHasReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractHasReceivablesRequest $request, ContractHasReceivableService $contractHasReceivableService): JsonResponse
    {
        $query = $contractHasReceivableService->filter($request);

        $contractHasReceivables = $query->get();

        return response()->json(['data' => ContractHasReceivableResource::collection($contractHasReceivables)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractHasReceivableRequest $request, ContractHasReceivableService $contractHasReceivableService): JsonResponse
    {
        $contractHasReceivable = $contractHasReceivableService->create($request);

        return response()->json(['data' => ContractHasReceivableResource::make($contractHasReceivable), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractHasReceivable $contractHasReceivable): JsonResponse
    {
        return response()->json(ContractHasReceivableResource::make($contractHasReceivable));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractHasReceivableRequest $request, ContractHasReceivable $contractHasReceivable, ContractHasReceivableService $contractHasReceivableService): JsonResponse
    {
        $contractHasReceivable = $contractHasReceivableService->update($contractHasReceivable, $request);

        return response()->json(['data' => ContractHasReceivableResource::make($contractHasReceivable), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractHasReceivable $contractHasReceivable): JsonResponse
    {
        $contractHasReceivable->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
