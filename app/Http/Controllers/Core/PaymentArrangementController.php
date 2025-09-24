<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentArrangements\GetPaymentArrangementsRequest;
use App\Http\Requests\PaymentArrangements\StorePaymentArrangementRequest;
use App\Http\Requests\PaymentArrangements\UpdatePaymentArrangementRequest;
use App\Http\Resources\PaymentArrangementResource;
use App\Models\Core\PaymentArrangement;
use App\Services\Core\PaymentArrangementService;
use Illuminate\Http\JsonResponse;

class PaymentArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPaymentArrangementsRequest $request, PaymentArrangementService $paymentArrangementService): JsonResponse
    {
        $query = $paymentArrangementService->filter($request);

        $paymentArrangements = $query->get();

        return response()->json(['data' => PaymentArrangementResource::collection($paymentArrangements)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentArrangementRequest $request, PaymentArrangementService $paymentArrangementService): JsonResponse
    {
        $paymentArrangement = $paymentArrangementService->create($request);

        return response()->json(['data' => PaymentArrangementResource::make($paymentArrangement), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentArrangement $paymentArrangement): JsonResponse
    {
        return response()->json(PaymentArrangementResource::make($paymentArrangement));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentArrangementRequest $request, PaymentArrangement $paymentArrangement, PaymentArrangementService $paymentArrangementService): JsonResponse
    {
        $paymentArrangement = $paymentArrangementService->update($paymentArrangement, $request);

        return response()->json(['data' => PaymentArrangementResource::make($paymentArrangement), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentArrangement $paymentArrangement): JsonResponse
    {
        $paymentArrangement->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
