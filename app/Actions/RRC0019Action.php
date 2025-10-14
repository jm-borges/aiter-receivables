<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;
use App\DataTransferObjects\Nuclea\ConfirmOperationRequest;
use App\Enums\OperationStatus;
use App\Models\Core\Action;
use App\Models\Core\Operation;
use Illuminate\Support\Collection;

class RRC0019Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function createReceivablesSet(): array
    {
        return $this->nucleaApiClient->makeRequest('post', 'financiadora/conjuntos-unidades-recebiveis', []);
    }

    public function addReceivablesToSet(string $identdConjUniddRecbvl, Collection $receivableUnits): array
    {
        return $this->nucleaApiClient->makeRequest('post', 'financiadora/conjuntos-unidades-recebiveis/' . $identdConjUniddRecbvl . '/lotes-unidades-recebiveis', $receivableUnits->toArray());
    }

    public function confirmOperation(Operation $operation, ConfirmOperationRequest $request): array
    {
        $response = $this->nucleaApiClient->makeRequest(
            'post',
            'financiadora/operacoes',
            $request->toArray()
        );

        if ($response['status_code'] === 202) {
            $operation->update(['status' => OperationStatus::WAITING_RESPONSE]);
        } else {
            $operation->update(['status' => OperationStatus::ERROR]);
        }

        return $response;
    }
}
