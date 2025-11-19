<?php

namespace App\Auxiliary;

class ReceivableData
{
    public function __construct(
        public ?string $cnpjCreddrSub,
        public ?float $VlrNegcd,
        public ?string $codInstitdrArrajPgto,
        public ?string $dtPrevtLiquid,
        public ?float $vlrTot,
        public array $titulares = [],
        public ?string $indrDomcl = null,
        public ?string $cnpjER = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            cnpjCreddrSub: $data['cnpjCreddrSub'] ?? null,
            VlrNegcd: isset($data['VlrNegcd']) ? (float)$data['VlrNegcd'] : null,
            codInstitdrArrajPgto: $data['codInstitdrArrajPgto'] ?? null,
            dtPrevtLiquid: $data['dtPrevtLiquid'] ?? null,
            vlrTot: isset($data['vlrTot']) ? (float)$data['vlrTot'] : null,
            titulares: $data['titulares'] ?? [],
            indrDomcl: $data['indrDomcl'] ?? null,
            cnpjER: $data['cnpjER'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'cnpjCreddrSub' => $this->cnpjCreddrSub,
            'VlrNegcd' => $this->VlrNegcd,
            'codInstitdrArrajPgto' => $this->codInstitdrArrajPgto,
            'dtPrevtLiquid' => $this->dtPrevtLiquid,
            'vlrTot' => $this->vlrTot,
            'titulares' => $this->titulares,
            'indrDomcl' => $this->indrDomcl,
            'cnpjER' => $this->cnpjER,
        ];
    }
}
