<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractPayments\GetContractPaymentsRequest;
use App\Http\Requests\ContractPayments\StoreContractPaymentRequest;
use App\Http\Requests\ContractPayments\UpdateContractPaymentRequest;
use App\Http\Resources\ContractPaymentResource;
use App\Models\Core\ContractPayment;
use App\Services\Core\ContractPaymentService;
use Illuminate\Http\JsonResponse;

class ContractPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetContractPaymentsRequest $request, ContractPaymentService $contractPaymentService): JsonResponse
    {
        $query = $contractPaymentService->filter($request);

        $contractPayments = $query->get();

        return response()->json(['data' => ContractPaymentResource::collection($contractPayments)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractPaymentRequest $request, ContractPaymentService $contractPaymentService): JsonResponse
    {
        $contractPayment = $contractPaymentService->create($request);

        return response()->json(['data' => ContractPaymentResource::make($contractPayment), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractPayment $contractPayment): JsonResponse
    {
        return response()->json(ContractPaymentResource::make($contractPayment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractPaymentRequest $request, ContractPayment $contractPayment, ContractPaymentService $contractPaymentService): JsonResponse
    {
        $contractPayment = $contractPaymentService->update($contractPayment, $request);

        return response()->json(['data' => ContractPaymentResource::make($contractPayment), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractPayment $contractPayment): JsonResponse
    {
        $contractPayment->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
