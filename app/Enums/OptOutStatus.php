<?php

namespace App\Enums;

enum OptOutStatus: string
{
    case CONFIRMED    = 'successful';
    case PENDING      = 'pending';
    case HAS_ERRORS   = 'has_errors';

    public function label(): string
    {
        return match ($this) {
            self::CONFIRMED   => 'Confirmado',
            self::PENDING     => 'Pendente',
            self::HAS_ERRORS  => 'Possui erros',
        };
    }
}
