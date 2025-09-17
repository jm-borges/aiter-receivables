<?php

namespace App\Http\Controllers;

use App\Http\Requests\Merchants\GetMerchantsRequest;
use App\Http\Requests\Merchants\StoreMerchantRequest;
use App\Http\Requests\Merchants\UpdateMerchantRequest;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use App\Services\MerchantService;
use Illuminate\Http\JsonResponse;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetMerchantsRequest $request, MerchantService $merchantService): JsonResponse
    {
        $query = $merchantService->filter($request);

        $merchants = $query->get();

        return response()->json(['data' => MerchantResource::collection($merchants)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMerchantRequest $request, MerchantService $merchantService): JsonResponse
    {
        $merchant = $merchantService->create($request);

        return response()->json(['data' => MerchantResource::make($merchant), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): JsonResponse
    {
        return response()->json(MerchantResource::make($merchant));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMerchantRequest $request, Merchant $merchant, MerchantService $merchantService): JsonResponse
    {
        $merchant = $merchantService->update($merchant, $request);

        return response()->json(['data' => MerchantResource::make($merchant), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchant $merchant): JsonResponse
    {
        $merchant->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}