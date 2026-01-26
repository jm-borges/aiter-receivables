<?php

namespace App\Enums;

enum ContractOperationType: string
{
    case RECUPERACAO_INADIMPLENCIA = 'recuperacao_inadimplencia'; //Recuperação de inadimplência
    case COLATERAL  = 'colateral'; //Colateral com recebíveis a performar
}
