<?php

namespace App\Handlers;

use App\Actions\RRC0021Action;
use App\Models\Core\Operation;
use App\Services\Core\ReceivableService;

class OperationsUpdater
{
    public function syncOperationFromRegistrar(Operation $operation): void
    {
        $response = app(RRC0021Action::class)->find($operation->identdOp);

        if ($response['status_code'] === 200) {
            $this->handleSuccessfulRRC0021($operation, $response);
        }
    }

    private function handleSuccessfulRRC0021(Operation $operation, array $response): void
    {
        $operationData = $response['body'];
        $receivablesData = $operationData['unidadesRecebiveis'];

        foreach ($receivablesData as $receivableData) {
            $this->handleReceivableData($operation, $receivableData);
        }
    }

    private function handleReceivableData(Operation $operation, array $receivableData): void
    {
        $receivable = app(ReceivableService::class)->findReceivable($operation->client, $receivableData);

        if ($receivable) {
            $operation
                ->receivables()
                ->updateExistingPivot($receivable->id, ['amount' => $receivableData['VlrNegcd']]);
        }
    }
}
