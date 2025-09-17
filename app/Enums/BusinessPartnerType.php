<?php

namespace App\Enums;

enum BusinessPartnerType: string
{
    case CLIENT   = 'client';
    case SUPPLIER = 'supplier';
    case ACQUIRER = 'acquirer';

    public function label(): string
    {
        return match ($this) {
            self::CLIENT   => 'Cliente',
            self::SUPPLIER => 'Fornecedor',
            self::ACQUIRER => 'Adquirente',
        };
    }
}
