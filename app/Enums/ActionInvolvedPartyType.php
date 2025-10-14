<?php

namespace App\Enums;

enum ActionInvolvedPartyType: string
{
    case FINANCIER    = 'financier';
    case REGISTRAR    = 'registrar';
    case ACCREDITATOR = 'accreditator';
    case FINANCIER_AND_REGISTRAR = 'financier_and_registrar';
    case FINANCIER_AND_ACCREDITATOR = 'financier_and_accreditator';
    case REGISTRAR_AND_ACCREDITATOR = 'registrar_and_accreditator';
    case ALL = 'all';

    public function label(): string
    {
        return match ($this) {
            self::FINANCIER => 'Instituição Financeira/Não-Financeira',
            self::REGISTRAR => 'Registradora',
            self::ACCREDITATOR => 'Credenciadora/Subcredenciadora',
            self::FINANCIER_AND_REGISTRAR => 'Instituição Financeira/Não-Financeira e Registradora',
            self::FINANCIER_AND_ACCREDITATOR => 'Instituição Financeira/Não-Financeira e Credenciadora/Subcredenciadora',
            self::REGISTRAR_AND_ACCREDITATOR => 'Registradora e Credenciadora/Subcredenciadora',
            self::ALL => 'Todos os participantes do ecossistema',
        };
    }
}
