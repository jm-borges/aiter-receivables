<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationParticipanteRequest extends ConfirmOperationRequest
{
    public array $cessionariosAutorizados = [];
    public array $renegociacoesDividas = [];
    public array $titulares = [];
}
