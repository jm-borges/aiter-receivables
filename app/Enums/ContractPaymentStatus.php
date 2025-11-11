<?php

namespace App\Enums;

enum ContractPaymentStatus: string
{
    case PENDING = 'pending';
    case PAID    = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::PAID    => 'Pago',
        };
    }
}
