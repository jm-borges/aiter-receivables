<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessPartners\GetBusinessPartnersRequest;
use App\Http\Requests\BusinessPartners\StoreBusinessPartnerRequest;
use App\Http\Requests\BusinessPartners\UpdateBusinessPartnerRequest;
use App\Http\Resources\BusinessPartnerResource;
use App\Models\Core\BusinessPartner;
use App\Services\Core\BusinessPartnerService;
use Illuminate\Http\JsonResponse;

class BusinessPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetBusinessPartnersRequest $request, BusinessPartnerService $businessPartnerService): JsonResponse
    {
        $query = $businessPartnerService->filter($request);

        $businessPartners = $query->get();

        return response()->json(['data' => BusinessPartnerResource::collection($businessPartners)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessPartnerRequest $request, BusinessPartnerService $businessPartnerService): JsonResponse
    {
        $businessPartner = $businessPartnerService->create($request);

        return response()->json(['data' => BusinessPartnerResource::make($businessPartner), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessPartner $businessPartner): JsonResponse
    {
        return response()->json(BusinessPartnerResource::make($businessPartner));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessPartnerRequest $request, BusinessPartner $businessPartner, BusinessPartnerService $businessPartnerService): JsonResponse
    {
        $businessPartner = $businessPartnerService->update($businessPartner, $request);

        return response()->json(['data' => BusinessPartnerResource::make($businessPartner), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessPartner $businessPartner): JsonResponse
    {
        $businessPartner->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
