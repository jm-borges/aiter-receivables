<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationParticipanteRequest extends ConfirmOperationRequest
{
    public ?string $identdComnc = null;
    public ?string $identdConjUniddRecbvl = null;
    public array $cessionariosAutorizados = [];
    public array $renegociacoesDividas = [];
}
