<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;
use InvalidArgumentException;

class RRC0021Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function get(
        ?string $cnpjOuCnpjBaseOuCpfUsuFinalRecbdr = null,
        ?string $codInstitdrArrajPgto = null,
        ?string $cnpjCreddrSub = null,
        ?string $dtPrevtLiquid = null,
        ?string $vlrLivre = null,
        ?string $dtIniPrevtLiquid = null,
        ?string $dtFimPrevtLiquid = null,
        ?string $indrTpNegc = null,
        ?string $cnpjOuCnpjBaseOuCpfTitlar = null,
        ?string $indrInterop = null,
        ?string $numeroPagina = null,
        ?string $tamanhoPagina = null,
        ?int $identificadorTransacao = null,
    ): array {
        if (empty($cnpjOuCnpjBaseOuCpfUsuFinalRecbdr) && empty($cnpjOuCnpjBaseOuCpfTitlar)) {
            throw new InvalidArgumentException(
                "É obrigatório informar pelo menos um dos campos: " .
                    "'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' ou 'cnpjOuCnpjBaseOuCpfTitlar'."
            );
        }

        $payload = array_filter([
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $cnpjOuCnpjBaseOuCpfUsuFinalRecbdr,
            'codInstitdrArrajPgto'              => $codInstitdrArrajPgto,
            'cnpjCreddrSub'                     => $cnpjCreddrSub,
            'dtPrevtLiquid'                     => $dtPrevtLiquid,
            'vlrLivre'                          => $vlrLivre,
            'dtIniPrevtLiquid'                  => $dtIniPrevtLiquid,
            'dtFimPrevtLiquid'                  => $dtFimPrevtLiquid,
            'indrTpNegc'                        => $indrTpNegc,
            'cnpjOuCnpjBaseOuCpfTitlar'         => $cnpjOuCnpjBaseOuCpfTitlar,
            'indrInterop'                       => $indrInterop,
            'numeroPagina'                      => $numeroPagina,
            'tamanhoPagina'                     => $tamanhoPagina,
            'identificadorTransacao'            => $identificadorTransacao,
        ], fn($value) => $value !== null);

        return $this->nucleaApiClient->makeRequest('get', 'unidades-recebiveis', $payload);
    }

    public function find(string $operationIdentifier): array
    {
        return $this->nucleaApiClient->makeRequest('get', 'financiadora/operacoes/' . $operationIdentifier);
    }
}
