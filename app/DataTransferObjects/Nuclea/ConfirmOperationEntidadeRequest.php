<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationParticipanteRequest extends ConfirmOperationRequest
{
    public ?string $indrPeriodRecalc = null;
    public ?string $diaExeccRecalc = null;
    public array $cessionariosAutorizados = [];
    public array $renegociacoesDividas = [];
    public array $titulares = [];
}
