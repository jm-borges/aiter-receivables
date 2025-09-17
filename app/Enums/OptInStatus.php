<?php

namespace App\Enums;

enum OptInStatus: string
{
    case ACTIVE    = 'active';
    case PENDING   = 'pending';
    case FINISHED  = 'finished';
    case OPTED_OUT = 'opted-out';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Ativo',
            self::PENDING   => 'Pendente',
            self::FINISHED  => 'Encerrado',
            self::OPTED_OUT => 'Opted-out',
        };
    }
}
