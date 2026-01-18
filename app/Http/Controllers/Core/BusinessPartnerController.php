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

    public function creditAnalysisByCnpj(string $cnpj): JsonResponse
    {
        $businessPartner = BusinessPartner::findByDocumentNumber($cnpj);

        return response()->json([
            "company_name" => $businessPartner->name,

            "warranty" => [
                "free" => 15989,
                "receivable" => 547327.54,
                "locked" => 752354.27,
            ],

            "payables" => [
                "total" => 100000,
            ],

            "receivables" => [
                "total" => 150000,
            ],

            "bank" => [
                "limit_total" => 756803163,
                "limit_used" => 54707356.54,
                "limit_available" => 752354.27,
            ],

            "warranty_history" => [
                ["date" => "2025-09-29", "label" => "29 Seg", "value" => 83000],
                ["date" => "2025-09-30", "label" => "30 Ter", "value" => 86000],
                ["date" => "2025-10-01", "label" => "01 Qua", "value" => 78000],
                ["date" => "2025-10-02", "label" => "02 Qui", "value" => 82000],
                ["date" => "2025-10-03", "label" => "03 Sex", "value" => 71000],
                ["date" => "2025-10-04", "label" => "04 Sab", "value" => 29000],
                ["date" => "2025-10-05", "label" => "05 Dom", "value" => 39000],
                ["date" => "2025-10-06", "label" => "06 Seg", "value" => 80000],
                ["date" => "2025-10-07", "label" => "07 Ter", "value" => 68000],
                ["date" => "2025-10-08", "label" => "08 Qua", "value" => 83000],
                ["date" => "2025-10-09", "label" => "Hoje Qui", "value" => 33000, "is_today" => true],
            ],

            "payments_vs_revenue" => [
                "labels" => ["Fev 2025", "Mar 2025", "Abr 2025", "Mai 2025", "Jun 2025", "Jul 2025", "Ago 2025", "Set 2025"],
                "series" => [
                    [
                        "key" => "revenue",
                        "label" => "Faturamento",
                        "color" => "#1b0f3b",
                        "values" => [200, 130, 140, 130, 150, 160, 140, 150],
                    ],
                    [
                        "key" => "payments",
                        "label" => "Pagamentos",
                        "color" => "#6b57b5",
                        "values" => [50, 60, 80, 60, 80, 90, 125, 100],
                    ],
                ],
            ],
            "bank_debt_evolution" => [
                "labels" => [
                    "Fev 2025",
                    "Mar 2025",
                    "Abr 2025",
                    "Mai 2025",
                    "Jun 2025",
                    "Jul 2025",
                    "Ago 2025",
                    "Set 2025"
                ],
                "series" => [
                    [
                        "key" => "due",
                        "label" => "A vencer",
                        "color" => "#2563eb", // azul
                        "values" => [72000, 75000, 78000, 81000, 79000, 83000, 87000, 90000],
                    ],
                    [
                        "key" => "overdue",
                        "label" => "Inadimplência",
                        "color" => "#dc2626", // vermelho
                        "values" => [0, 10000, 0, 60000, 0, 180000, 10000, 0],
                    ],
                ],
            ],

            "bank_debt_profile" => [
                [
                    "key" => "short",
                    "label" => "Curto prazo",
                    "value" => 25,
                ],
                [
                    "key" => "medium",
                    "label" => "Médio prazo",
                    "value" => 40,
                ],
                [
                    "key" => "long",
                    "label" => "Longo prazo",
                    "value" => 30,
                ],
                [
                    "key" => "losses",
                    "label" => "Perdas",
                    "value" => 5,
                ],
            ],


        ]);
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
