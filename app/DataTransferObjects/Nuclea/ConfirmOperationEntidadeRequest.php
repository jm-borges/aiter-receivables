<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationEntidadeRequest extends ConfirmOperationRequest
{
    public ?string $indrPeriodRecalc = null;
    public ?string $diaExeccRecalc = null;
    public array $cessionariosAutorizados = [];
    public array $renegociacoesDividas = [];
    public array $titulares = [];
}
