<?php

namespace App\Handlers;

use App\Actions\RRC0021Action;
use App\Auxiliary\ReceivableData;
use App\Enums\OperationStatus;
use App\Models\Core\Operation;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;

/** Aqui assumimos que todas as URs que ainda não foram liquidadas vão estar no banco de dados */
class OperationsUpdater
{
    public function updatesOperations(): void
    {
        $operations = Operation::with('contract.client')
            ->where('status', OperationStatus::ACCEPTED)->get();

        foreach ($operations as $operation) {
            $this->syncOperationFromRegistrar($operation);
        }
    }

    private function syncOperationFromRegistrar(Operation $operation): float
    {
        if (!$operation->identdOp) {
            return 0;
        }

        $rrc0021 = app(RRC0021Action::class);
        $response = $rrc0021->find($operation->identdOp);

        if ($response['status_code'] !== 200) {
            return 0;
        }

        return $this->handleSuccessfulRRC0021($operation, $response['body'], $rrc0021);
    }

    private function handleSuccessfulRRC0021(Operation $operation, array $operationData, RRC0021Action $rrc0021): float
    {
        $total = 0;

        $total += $this->syncReceivableUnits(
            $operation,
            $operationData['unidadesRecebiveis']['href'] ?? null,
            fn() => $rrc0021->findReceivableUnits($operation->identdOp),
        );

        $total += $this->syncReceivableUnits(
            $operation,
            $operationData['unidadesRecebiveisAConstituir']['href'] ?? null,
            fn() => $rrc0021->findReceivableUnitsToConstitute($operation->identdOp),
        );

        return $total;
    }

    private function syncReceivableUnits(
        Operation $operation,
        ?string $href,
        callable $fetcher
    ): float {
        if (!$href) {
            return 0;
        }

        $response = $fetcher();

        if ($response['status_code'] !== 200) {
            return 0;
        }

        return $this->processReceivableUnits($operation, $response['body']);
    }

    private function processReceivableUnits(Operation $operation, array $units): float
    {
        $total = 0;

        foreach ($units as $unit) {
            $dto = ReceivableData::fromArray($unit);
            $total += $this->handleReceivableData($operation, $dto);
        }

        return $total;
    }

    private function handleReceivableData(Operation $operation, ReceivableData $receivableData): float
    {
        $receivable = app(ReceivableService::class)
            ->findReceivable($operation->contract->client, $receivableData);

        if (!$receivable) {
            return 0;
        }

        return $this->updateOperationReceivable($operation, $receivable, $receivableData);
    }

    private function updateOperationReceivable(
        Operation $operation,
        Receivable $receivable,
        ReceivableData $receivableData
    ): float {
        $negotiatedValue = $receivableData->vlrNegcd ?? 0;

        $operation
            ->receivables()
            ->syncWithoutDetaching([
                $receivable->id => [
                    'amount' => $negotiatedValue,
                ],
            ]);

        return $negotiatedValue;
    }
}
