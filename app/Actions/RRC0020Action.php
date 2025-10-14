<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;
use App\DataTransferObjects\Nuclea\CancelOperationRequest;
use App\DataTransferObjects\Nuclea\ConfirmOperationRequest;
use Illuminate\Support\Collection;

class RRC0020Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function execute(CancelOperationRequest $request, string $operationIdentifier): array
    {
        return $this->nucleaApiClient->makeRequest('patch', 'financiadora/operacoes/' . $operationIdentifier,  $request->toArray());
    }

    public function addReceivablesToSet(string $identdConjUniddRecbvl, Collection $receivableUnits): array
    {
        return $this->nucleaApiClient->makeRequest('post', 'financiadora/conjuntos-unidades-recebiveis/' . $identdConjUniddRecbvl . '/lotes-unidades-recebiveis', $receivableUnits->toArray());
    }

    public function confirmOperation(ConfirmOperationRequest $request): array
    {
        return $this->nucleaApiClient->makeRequest(
            'post',
            'financiadora/operacoes',
            $request->toArray()
        );
    }
}
