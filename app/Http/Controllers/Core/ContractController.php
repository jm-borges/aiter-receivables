<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contracts\GetContractsRequest;
use App\Http\Requests\Contracts\StoreContractRequest;
use App\Http\Requests\Contracts\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Core\Contract;
use App\Services\Core\ContractService;
use Illuminate\Http\JsonResponse;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractsRequest $request, ContractService $contractService): JsonResponse
    {
        $query = $contractService->filter($request);

        $contracts = $query->get();

        return response()->json(['data' => ContractResource::collection($contracts)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request, ContractService $contractService): JsonResponse
    {
        $contract = $contractService->create($request->all());

        return response()->json(['data' => ContractResource::make($contract), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract): JsonResponse
    {
        return response()->json(ContractResource::make($contract));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract, ContractService $contractService): JsonResponse
    {
        $contract = $contractService->update($contract, $request->all());

        return response()->json(['data' => ContractResource::make($contract), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract): JsonResponse
    {
        $contract->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
