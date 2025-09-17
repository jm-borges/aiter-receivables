<?php

namespace App\DataTransferObjects\Nuclea;

abstract class CancelOperationRequest
{
    public string $op = 'cancelamento';
    public string $identdNegcRecbvl;
    public string $indrCancelVlrTotal; // "S" ou "N"
    public string $indrLiquidOp;
    public string $indrCancelCessConstitr;
    public string $identdComnc;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
