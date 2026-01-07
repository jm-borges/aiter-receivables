<?php

namespace App\Auxiliary;

class ReceivableData
{
    public function __construct(
        public ?string $cnpjCreddrSub = null,
        public ?string $codInstitdrArrajPgto = null,
        public ?string $dtPrevtLiquid = null,

        // Valores diretos
        public ?float $vlrNegcd = null,
        public ?float $vlrTot = null,

        // Percentuais
        public ?float $vlrPercNegcdConstitr = null,
        public ?float $vlrPercNegcdConstitrSolctd = null,
        public ?float $vlrPercNegcdSolctd = null,

        // Outros
        public array $titulares = [],
        public ?string $indrDomcl = null,
        public ?string $cnpjER = null,

        // Guarda o payload bruto se quiser debugar
        public array $raw = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            cnpjCreddrSub: $data['cnpjCreddrSub'] ?? null,
            codInstitdrArrajPgto: $data['codInstitdrArrajPgto'] ?? null,
            dtPrevtLiquid: $data['dtPrevtLiquid'] ?? null,

            vlrNegcd: isset($data['vlrNegcd']) ? (float) $data['vlrNegcd'] : null,
            vlrTot: isset($data['vlrTot']) ? (float) $data['vlrTot'] : null,

            vlrPercNegcdConstitr: isset($data['vlrPercNegcdConstitr']) ? (float) $data['vlrPercNegcdConstitr'] : null,
            vlrPercNegcdConstitrSolctd: isset($data['vlrPercNegcdConstitrSolctd']) ? (float) $data['vlrPercNegcdConstitrSolctd'] : null,
            vlrPercNegcdSolctd: isset($data['vlrPercNegcdSolctd']) ? (float) $data['vlrPercNegcdSolctd'] : null,

            titulares: $data['titulares'] ?? [],
            indrDomcl: $data['indrDomcl'] ?? null,
            cnpjER: $data['cnpjER'] ?? null,

            raw: $data,
        );
    }

    public function toArray(): array
    {
        return [
            'cnpjCreddrSub' => $this->cnpjCreddrSub,
            'codInstitdrArrajPgto' => $this->codInstitdrArrajPgto,
            'dtPrevtLiquid' => $this->dtPrevtLiquid,

            // Valores
            'vlrNegcd' => $this->vlrNegcd,
            'vlrTot' => $this->vlrTot,

            // Percentuais
            'vlrPercNegcdConstitr' => $this->vlrPercNegcdConstitr,
            'vlrPercNegcdConstitrSolctd' => $this->vlrPercNegcdConstitrSolctd,
            'vlrPercNegcdSolctd' => $this->vlrPercNegcdSolctd,

            // Outros
            'titulares' => $this->titulares,
            'indrDomcl' => $this->indrDomcl,
            'cnpjER' => $this->cnpjER,

            // Debug / rastreabilidade
            'raw' => $this->raw,
        ];
    }
}
