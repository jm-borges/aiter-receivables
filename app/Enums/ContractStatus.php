<?php

namespace App\Enums;

enum ContractStatus: string
{
    case ACTIVE    = 'active';
    case FINISHED  = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Ativo',
            self::FINISHED  => 'Encerrado',
        };
    }
}
