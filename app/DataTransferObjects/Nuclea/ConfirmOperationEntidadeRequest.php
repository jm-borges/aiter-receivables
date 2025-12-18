<?php

namespace App\DataTransferObjects\Nuclea;

class ConfirmOperationEntidadeRequest extends ConfirmOperationRequest
{
    public function __construct(
        string $tpObj,
        string $identdNegcRecbvl,
        string $indrTpNegc,
        string $dtVencOp,
        float  $vlrTotLimOuSldDevdr,
        string $indrGestER,
        string $indrRegrDivs,
        string $indrAlcancContrtoCreddrSub,
        string $indrActeIncondlOp,
        string $indrActeUniddRecbvlReserv,
        public array  $titulares = [],
        public ?string $indrPeriodRecalc = null,
        public ?string $diaExeccRecalc = null,
        public array  $cessionariosAutorizados = [],
        public array  $renegociacoesDividas = [],
        public ?float $vlrGar = null,
    ) {
        parent::__construct(
            $tpObj,
            $identdNegcRecbvl,
            $indrTpNegc,
            $dtVencOp,
            $vlrTotLimOuSldDevdr,
            $indrGestER,
            $indrRegrDivs,
            $indrAlcancContrtoCreddrSub,
            $indrActeIncondlOp,
            $indrActeUniddRecbvlReserv,

        );
    }
}
