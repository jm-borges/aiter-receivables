<?php

namespace App\Handlers;

use App\Actions\RRC0021Action;
use App\Auxiliary\ReceivableData;
use App\Enums\OperationStatus;
use App\Models\Core\Operation;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;

class OperationsUpdater
{
    public function updatesOperations(): void
    {
        $operations = Operation::where('status', OperationStatus::ACCEPTED)->get();

        foreach ($operations as $operation) {
            $currentNegotiatedValue += $this->syncOperationFromRegistrar($operation);
        }
    }

    private function syncOperationFromRegistrar(Operation $operation): float
    {
        if ($operation->identdOp) {
            $response = app(RRC0021Action::class)->find($operation->identdOp);

            if ($response['status_code'] === 200) {
                return $this->handleSuccessfulRRC0021($operation, $response);
            }
        }

        return 0;
    }

    private function handleSuccessfulRRC0021(Operation $operation, array $response): float
    {
        $operationData = $response['body'];
        $receivablesData = $operationData['unidadesRecebiveis'];
        $currentNegotiatedValue = 0;

        /*  foreach ($receivablesData as $receivableData) { 
            $receivableData = ReceivableData::fromArray($receivableData);
            $currentNegotiatedValue += $this->handleReceivableData($operation, $receivableData);
        }
 */
        return $currentNegotiatedValue;
    }

    private function handleReceivableData(Operation $operation, ReceivableData $receivableData): float
    {
        $receivable = app(ReceivableService::class)->findReceivable($operation->client, $receivableData);

        if ($receivable) {
            return $this->updateOperationReceivable($operation, $receivable, $receivableData);
        }

        return 0;
    }

    private function updateOperationReceivable(Operation $operation, Receivable $receivable, ReceivableData $receivableData): float
    {
        $negotiatedValue = $receivableData->VlrNegcd;

        $operation
            ->receivables()
            ->updateExistingPivot(
                $receivable->id,
                ['amount' => $negotiatedValue],
            );

        return $negotiatedValue;
    }
}
