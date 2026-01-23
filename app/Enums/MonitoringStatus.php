<?php

namespace App\Enums;

enum MonitoringStatus: string
{
    case INCREASING_REVENUE = 'increasing_revenue';
    case DECREASING_REVENUE = 'decreasing_revenue';
    case STABLE = 'stable';
    case POTENTIAL = 'potential';

    public function color(): string
    {
        return match ($this) {
            self::INCREASING_REVENUE => 'green',
            self::DECREASING_REVENUE => 'red',
            self::POTENTIAL => 'yellow',
            self::STABLE => 'gray',
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::INCREASING_REVENUE => 'Aumento no faturamento',
            self::DECREASING_REVENUE => 'Faturamento em queda',
            self::POTENTIAL => 'Potencial',
            self::STABLE => 'Estável',
        };
    }

    public function subtitle(?float $variationPercent = null): string
    {
        return match ($this) {
            self::INCREASING_REVENUE =>
            'Faturamento aumentou ' . number_format($variationPercent ?? 0, 1, ',', '.') . '% neste mês',

            self::DECREASING_REVENUE =>
            'Queda de ' . number_format(abs($variationPercent ?? 0), 1, ',', '.') . '% neste mês',

            self::POTENTIAL =>
            'Aumento no potencial de garantias',

            self::STABLE =>
            'Sem variações relevantes',
        };
    }
}
