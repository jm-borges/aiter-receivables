<?php

namespace App\Http\Controllers\Core\Pivots;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractHasAcquirers\GetContractHasAcquirersRequest;
use App\Http\Requests\ContractHasAcquirers\StoreContractHasAcquirerRequest;
use App\Http\Requests\ContractHasAcquirers\UpdateContractHasAcquirerRequest;
use App\Http\Resources\ContractHasAcquirerResource;
use App\Models\Core\Pivots\ContractHasAcquirer;
use App\Services\Core\Pivots\ContractHasAcquirerService;
use Illuminate\Http\JsonResponse;

class ContractHasAcquirerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractHasAcquirersRequest $request, ContractHasAcquirerService $contractHasAcquirerService): JsonResponse
    {
        $query = $contractHasAcquirerService->filter($request);

        $contractHasAcquirers = $query->get();

        return response()->json(['data' => ContractHasAcquirerResource::collection($contractHasAcquirers)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractHasAcquirerRequest $request, ContractHasAcquirerService $contractHasAcquirerService): JsonResponse
    {
        $contractHasAcquirer = $contractHasAcquirerService->create($request);

        return response()->json(['data' => ContractHasAcquirerResource::make($contractHasAcquirer), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractHasAcquirer $contractHasAcquirer): JsonResponse
    {
        return response()->json(ContractHasAcquirerResource::make($contractHasAcquirer));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractHasAcquirerRequest $request, ContractHasAcquirer $contractHasAcquirer, ContractHasAcquirerService $contractHasAcquirerService): JsonResponse
    {
        $contractHasAcquirer = $contractHasAcquirerService->update($contractHasAcquirer, $request);

        return response()->json(['data' => ContractHasAcquirerResource::make($contractHasAcquirer), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractHasAcquirer $contractHasAcquirer): JsonResponse
    {
        $contractHasAcquirer->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
