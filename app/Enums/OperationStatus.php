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
            self::ERROR     => 'Erro',
        };
    }

    public function cssClass(): string
    {
        return match ($this) {
            self::ACTIVE    => 'text-green-600 font-semibold',
            self::PENDING   => 'text-yellow-600 font-semibold',
            self::FINISHED  => 'text-gray-600 font-semibold',
            self::ACCEPTED  => 'text-blue-600 font-semibold',
            self::REFUSED   => 'text-red-600 font-semibold',
            self::WAITING_RESPONSE => 'text-orange-600 font-semibold',
            self::ERROR     => 'text-red-800 font-semibold',
        };
    }
}
