<?php

namespace App\Enums;

enum OperationStatus: string
{
    case ACTIVE    = 'active';
    case PENDING   = 'pending';
    case FINISHED  = 'finished';
    case ACCEPTED  = 'accepted';
    case REFUSED   = 'refused';
    case WAITING_RESPONSE = 'waiting_response';
    case ERROR     = 'error';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE    => 'Ativo',
            self::PENDING   => 'Pendente',
            self::FINISHED  => 'Encerrado',
            self::ACCEPTED  => 'Aceito',
            self::REFUSED   => 'Recusado',
            self::WAITING_RESPONSE => 'Aguardando retorno',
            self::ERROR     => 'Error',
        };
    }
}
