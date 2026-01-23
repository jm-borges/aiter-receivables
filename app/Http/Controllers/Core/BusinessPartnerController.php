<?php

namespace App\Http\Controllers\Core;

use App\Enums\ReceivableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessPartners\GetBusinessPartnersRequest;
use App\Http\Requests\BusinessPartners\StoreBusinessPartnerRequest;
use App\Http\Requests\BusinessPartners\UpdateBusinessPartnerRequest;
use App\Http\Resources\BusinessPartnerResource;
use App\Models\Core\BusinessPartner;
use App\Services\Core\BusinessPartnerService;
use App\Services\Core\ContractService;
use App\Services\Core\ReceivableService;
use App\Services\CreditAnalysis\CreditAnalysisService;
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

    public function receivablesSummary(string $id, ReceivableService $receivableService): JsonResponse
    {
        $summary = $receivableService->calculateReceivablesSummary($id);

        return response()->json($summary);
    }

    public function receivablesSummaryByCnpj(string $cnpj, ReceivableService $receivableService): JsonResponse
    {
        $summary = $receivableService->calculateReceivablesSummaryByCnpj($cnpj);

        return response()->json($summary);
    }

    public function contractPaymentsSummary(string $id, ContractService $contractService): JsonResponse
    {
        $summary = $contractService->calculatePaymentsSummary($id);

        return response()->json($summary);
    }

    public function creditAnalysis(string $id): JsonResponse
    {
        $businessPartner = BusinessPartner::find($id);

        $service = app(CreditAnalysisService::class);

        $data = $service->buildForBusinessPartner($businessPartner);

        return response()->json($data);
    }

    public function creditAnalysisByCnpj(string $cnpj): JsonResponse
    {
        $businessPartner = BusinessPartner::findByDocumentNumber($cnpj);

        $service = app(CreditAnalysisService::class);

        $data = $service->buildForBusinessPartner($businessPartner);

        return response()->json($data);
    }


    public function receivablesSchedule(string $id): JsonResponse
    {
        $businessPartner = BusinessPartner::find($id);

        $rows = $businessPartner
            ->clientReceivables()
            ->whereNotNull('dtPrevtLiquid')
            ->selectRaw("
        DATE(dtPrevtLiquid) as date,
        SUM(CASE WHEN status = ? THEN vlrTot ELSE 0 END) as received,
        SUM(CASE WHEN status IS NULL OR status != ? THEN vlrTot ELSE 0 END) as to_receive
    ", [
                ReceivableStatus::SETTLED->value,
                ReceivableStatus::SETTLED->value,
            ])
            ->groupByRaw('DATE(dtPrevtLiquid)')
            ->orderByRaw('DATE(dtPrevtLiquid)')
            ->get();


        return response()->json([
            'business_partner_id' => $businessPartner->id,
            'schedule' => $rows->map(fn($row) => [
                'date' => $row->date,
                'received' => (float) $row->received,
                'to_receive' => (float) $row->to_receive,
            ]),
        ]);
    }
}
