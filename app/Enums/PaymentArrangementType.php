<?php

namespace App\Enums;

enum PaymentArrangementType: string
{
    case CREDIT = 'credit';
    case DEBIT  = 'debit';

    public function label(): string
    {
        return match ($this) {
            self::CREDIT    => 'Crédito',
            self::DEBIT      => 'Débito',
        };
    }
}
