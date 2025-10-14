<?php

namespace App\Enums;

enum ActionType: string
{
    case FILE       = 'file';
    case MESSAGE    = 'message';

    public function label(): string
    {
        return match ($this) {
            self::FILE        => 'Arquivo',
            self::MESSAGE     => 'Mensagem',
        };
    }
}
