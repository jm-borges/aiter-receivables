<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractHasPaymentArrangements\GetContractHasPaymentArrangementsRequest;
use App\Http\Requests\ContractHasPaymentArrangements\StoreContractHasPaymentArrangementRequest;
use App\Http\Requests\ContractHasPaymentArrangements\UpdateContractHasPaymentArrangementRequest;
use App\Http\Resources\ContractHasPaymentArrangementResource;
use App\Models\ContractHasPaymentArrangement;
use App\Services\ContractHasPaymentArrangementService;
use Illuminate\Http\JsonResponse;

class ContractHasPaymentArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractHasPaymentArrangementsRequest $request, ContractHasPaymentArrangementService $contractHasPaymentArrangementService): JsonResponse
    {
        $query = $contractHasPaymentArrangementService->filter($request);

        $contractHasPaymentArrangements = $query->get();

        return response()->json(['data' => ContractHasPaymentArrangementResource::collection($contractHasPaymentArrangements)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractHasPaymentArrangementRequest $request, ContractHasPaymentArrangementService $contractHasPaymentArrangementService): JsonResponse
    {
        $contractHasPaymentArrangement = $contractHasPaymentArrangementService->create($request);

        return response()->json(['data' => ContractHasPaymentArrangementResource::make($contractHasPaymentArrangement), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractHasPaymentArrangement $contractHasPaymentArrangement): JsonResponse
    {
        return response()->json(ContractHasPaymentArrangementResource::make($contractHasPaymentArrangement));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractHasPaymentArrangementRequest $request, ContractHasPaymentArrangement $contractHasPaymentArrangement, ContractHasPaymentArrangementService $contractHasPaymentArrangementService): JsonResponse
    {
        $contractHasPaymentArrangement = $contractHasPaymentArrangementService->update($contractHasPaymentArrangement, $request);

        return response()->json(['data' => ContractHasPaymentArrangementResource::make($contractHasPaymentArrangement), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractHasPaymentArrangement $contractHasPaymentArrangement): JsonResponse
    {
        $contractHasPaymentArrangement->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}