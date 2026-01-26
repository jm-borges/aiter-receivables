<?php

namespace App\Services\CreditAnalysis;

use App\Models\Core\BusinessPartner;

class CreditAnalysisService
{
    public function buildForBusinessPartner(BusinessPartner $bp): array
    {
        return [
            'company_id' => $bp->id,
            'company_name' => $bp->name,

            'warranty' => $this->buildWarranty($bp),
            'payables' => $this->buildPayables($bp),
            'receivables' => $this->buildReceivables($bp),
            'bank' => $this->buildBankLimits($bp),

            'warranty_history' => $this->buildWarrantyHistory($bp),
            'payments_vs_revenue' => $this->buildPaymentsVsRevenue($bp),

            'bank_debt_evolution' => $this->buildBankDebtEvolution($bp),
            'bank_debt_profile' => $this->buildBankDebtProfile($bp),
        ];
    }

    protected function buildWarranty(BusinessPartner $bp): array
    {
        // mock por enquanto
        return [
            'free' => 15989,
            'receivable' => 547327.54,
            'locked' => 752354.27,
        ];
    }

    protected function buildPayables(BusinessPartner $bp): array
    {
        return [
            'total' => 100000,
        ];
    }

    protected function buildReceivables(BusinessPartner $bp): array
    {
        return [
            'total' => 150000,
        ];
    }

    protected function buildBankLimits(BusinessPartner $bp): array
    {
        return [
            'limit_total' => 756803163,
            'limit_used' => 54707356.54,
            'limit_available' => 752354.27,
        ];
    }

    protected function buildWarrantyHistory(BusinessPartner $bp): array
    {
        return [
            ['date' => '2025-09-29', 'label' => '29 Seg', 'value' => 83000],
            ['date' => '2025-09-30', 'label' => '30 Ter', 'value' => 86000],
            ['date' => '2025-10-01', 'label' => '01 Qua', 'value' => 78000],
            ['date' => '2025-10-02', 'label' => '02 Qui', 'value' => 82000],
            ['date' => '2025-10-03', 'label' => '03 Sex', 'value' => 71000],
            ['date' => '2025-10-04', 'label' => '04 Sab', 'value' => 29000],
            ['date' => '2025-10-05', 'label' => '05 Dom', 'value' => 39000],
            ['date' => '2025-10-06', 'label' => '06 Seg', 'value' => 80000],
            ['date' => '2025-10-07', 'label' => '07 Ter', 'value' => 68000],
            ['date' => '2025-10-08', 'label' => '08 Qua', 'value' => 83000],
            ['date' => '2025-10-09', 'label' => 'Hoje Qui', 'value' => 33000, 'is_today' => true],
        ];
    }

    protected function buildPaymentsVsRevenue(BusinessPartner $bp): array
    {
        return [
            'labels' => ['Fev 2025', 'Mar 2025', 'Abr 2025', 'Mai 2025', 'Jun 2025', 'Jul 2025', 'Ago 2025', 'Set 2025'],
            'series' => [
                [
                    'key' => 'revenue',
                    'label' => 'Faturamento',
                    'color' => '#1b0f3b',
                    'values' => [200, 130, 140, 130, 150, 160, 140, 150],
                ],
                [
                    'key' => 'payments',
                    'label' => 'Pagamentos',
                    'color' => '#6b57b5',
                    'values' => [50, 60, 80, 60, 80, 90, 125, 100],
                ],
            ],
        ];
    }

    protected function buildBankDebtEvolution(BusinessPartner $bp): array
    {
        return [
            'labels' => ['Fev 2025', 'Mar 2025', 'Abr 2025', 'Mai 2025', 'Jun 2025', 'Jul 2025', 'Ago 2025', 'Set 2025'],
            'series' => [
                [
                    'key' => 'due',
                    'label' => 'A vencer',
                    'color' => '#2563eb',
                    'values' => [72000, 75000, 78000, 81000, 79000, 83000, 87000, 90000],
                ],
                [
                    'key' => 'overdue',
                    'label' => 'Inadimplência',
                    'color' => '#dc2626',
                    'values' => [0, 10000, 0, 60000, 0, 180000, 10000, 0],
                ],
            ],
        ];
    }

    protected function buildBankDebtProfile(BusinessPartner $bp): array
    {
        return [
            ['key' => 'short', 'label' => 'Curto prazo', 'value' => 25],
            ['key' => 'medium', 'label' => 'Médio prazo', 'value' => 40],
            ['key' => 'long', 'label' => 'Longo prazo', 'value' => 30],
            ['key' => 'losses', 'label' => 'Perdas', 'value' => 5],
        ];
    }
}
