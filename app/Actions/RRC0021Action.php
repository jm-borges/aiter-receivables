<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;

class RRC0021Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function find(string $operationIdentifier): array
    {
        return $this->nucleaApiClient->makeRequest('get', 'financiadora/operacoes/' . $operationIdentifier);
    }

    public function findReceivableUnits(string $operationIdentifier): array
    {
        return $this->nucleaApiClient->makeRequest(
            'get',
            'financiadora/operacoes/' . $operationIdentifier . '/unidades-recebiveis'
        );
    }

    public function findReceivableUnitsToConstitute(string $operationIdentifier): array
    {
        return $this->nucleaApiClient->makeRequest(
            'get',
            'financiadora/operacoes/' . $operationIdentifier . '/unidades-recebiveis-a-constituir'
        );
    }
}
