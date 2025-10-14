<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;

class RRC0011Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function execute(
        ?string $identdCtrlReqSolicte = null,
        ?string $cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar = null,
        ?string $cnpjCreddrSub = null,
        ?string $cnpjFincdr = null,
        ?string $codInstitdrArrajPgto = null,
        ?string $dtOptIn = null,
        ?string $dtIniOptIn = null,
        ?string $dtFimOptIn = null,
        ?string $indrDomcl = null,
    ): array {
        $payload = array_filter([
            'identdCtrlReqSolicte'                      => $identdCtrlReqSolicte,
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar' => $cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar,
            'cnpjCreddrSub'                             => $cnpjCreddrSub,
            'cnpjFincdr'                                => $cnpjFincdr,
            'codInstitdrArrajPgto'                      => $codInstitdrArrajPgto,
            'dtOptIn'                                   => $dtOptIn,
            'dtIniOptIn'                                => $dtIniOptIn,
            'dtFimOptIn'                                => $dtFimOptIn,
            'indrDomcl'                                 => $indrDomcl,
        ], fn($value) => $value !== null);

        return $this->nucleaApiClient->makeRequest('post', 'anuencias', $payload);
    }
}
