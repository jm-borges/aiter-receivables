<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationEntidadeSemAlcanceRequest extends ConfirmOperationRequest
{
    public array $cessionariosAutorizados = [];
    public array $renegociacoesDividas = [];
    public array $titulares = [];
}
