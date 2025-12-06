<?php

namespace App\Enums;

enum ReceivableStatus: string
{
    case AVAILABLE = 'available';
    case SETTLED   = 'settled';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE    => 'Disponível',
            self::SETTLED      => 'Liquidado',
        };
    }
}
