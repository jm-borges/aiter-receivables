<?php

namespace App\Enums;

enum ContractStatus: string
{
    case ACTIVE    = 'active';
    case PENDING   = 'pending';
    case ERROR     = 'error';
    case FINISHED  = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Ativo',
            self::PENDING   => 'Pendente',
            self::ERROR     => 'Erro',
            self::FINISHED  => 'Encerrado',
        };
    }
}
