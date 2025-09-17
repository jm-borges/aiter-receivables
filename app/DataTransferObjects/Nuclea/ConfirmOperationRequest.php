<?php

namespace App\DataTransferObjects\Nuclea;

abstract class ConfirmOperationRequest
{
    public string $tpObj;
    public string $identdNegcRecbvl;
    public string $indrTpNegc;
    public string $dtVencOp;
    public float $vlrTotLimOuSldDevdr;
    public string $indrGestER;
    public string $indrRegrDivs;
    public string $indrAlcancContrtoCreddrSub;
    public string $indrActeIncondlOp;
    public string $indrActeUniddRecbvlReserv;
    public string $indrAutcCess;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
