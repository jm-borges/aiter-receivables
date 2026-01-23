<?php

namespace App\Services;

use App\Enums\MonitoringStatus;
use App\Models\Core\BusinessPartner;

class ClientMonitoringService
{
    public function buildForClient(BusinessPartner $client): array
    {
        $receivables = $client->clientReceivables();

        $currentStart = now()->startOfMonth();
        $currentEnd   = now()->endOfMonth();

        $previousStart = now()->subMonth()->startOfMonth();
        $previousEnd   = now()->subMonth()->endOfMonth();

        $currentRevenue = (float) $receivables
            ->clone()
            ->whereBetween('dtPrevtLiquid', [$currentStart, $currentEnd])
            ->sum('vlrTot');

        $previousRevenue = (float) $receivables
            ->clone()
            ->whereBetween('dtPrevtLiquid', [$previousStart, $previousEnd])
            ->sum('vlrTot');

        $variationPercent = $this->calculateVariation($previousRevenue, $currentRevenue);

        $status = $this->classifyStatus($previousRevenue, $currentRevenue, $variationPercent);

        return [
            'status' => $status,
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'variation_percent' => $variationPercent,
        ];
    }

    private function calculateVariation(float $previous, float $current): float
    {
        if ($previous == 0.0) {
            if ($current == 0.0) {
                return 0.0;
            }
            return 100.0; // crescimento “infinito” → tratamos como 100%
        }

        return (($current - $previous) / $previous) * 100;
    }

    private function classifyStatus(float $previous, float $current, float $variation): MonitoringStatus
    {
        // Não tinha nada e agora tem → potencial claro
        if ($previous == 0.0 && $current > 0.0) {
            return MonitoringStatus::POTENTIAL;
        }

        // Ambos zero → estável (sem operação ainda)
        if ($previous == 0.0 && $current == 0.0) {
            return MonitoringStatus::STABLE;
        }

        // Margem de neutralidade (ex: +-5%)
        if (abs($variation) < 5) {
            return MonitoringStatus::STABLE;
        }

        if ($variation > 0) {
            return MonitoringStatus::INCREASING_REVENUE;
        }

        return MonitoringStatus::DECREASING_REVENUE;
    }
}
