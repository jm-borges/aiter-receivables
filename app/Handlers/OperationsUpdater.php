<?php

namespace App\Handlers;

use App\Actions\RRC0021Action;
use App\Auxiliary\ReceivableData;
use App\Enums\OperationStatus;
use App\Models\Core\Operation;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;
use Illuminate\Support\Facades\Log;

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
        $receivablesData = $this->extractReceivablesData($operation, $response);

        $currentNegotiatedValue = 0;

        foreach ($receivablesData as $receivableData) {
            $receivableData = ReceivableData::fromArray($receivableData);
            $currentNegotiatedValue += $this->handleReceivableData($operation, $receivableData);
        }

        return $currentNegotiatedValue;
    }

    private function extractReceivablesData(Operation $operation, array $response): array
    {
        $operationData = $response['body'] ?? [];
        $receivablesData = $operationData['unidadesRecebiveis'] ?? null;

        $this->logReceivablesRaw($operation, $receivablesData);

        return $this->normalizeReceivablesData($operation, $receivablesData);
    }

    private function normalizeReceivablesData(Operation $operation, mixed $receivablesData): array
    {
        if (is_string($receivablesData)) {
            $decoded = json_decode($receivablesData, true);

            $this->logReceivablesDecodeAttempt($operation, $receivablesData, $decoded);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                $this->logReceivablesInvalid($operation, $receivablesData);

                throw new \UnexpectedValueException(
                    'unidadesRecebiveis inválido ou JSON malformado'
                );
            }

            return $decoded;
        }

        if (!is_array($receivablesData)) {
            Log::error('RRC0021 - unidadesRecebiveis não é array após normalização', [
                'operation_id' => $operation->id ?? null,
                'final_type' => gettype($receivablesData),
            ]);

            throw new \UnexpectedValueException(
                'unidadesRecebiveis deve ser um array'
            );
        }

        return $receivablesData;
    }

    private function logReceivablesDecodeAttempt(
        Operation $operation,
        string $raw,
        mixed $decoded
    ): void {
        Log::debug('RRC0021 - tentativa de decode de unidadesRecebiveis', [
            'operation_id' => $operation->id ?? null,
            'json_error' => json_last_error_msg(),
            'decoded_type' => gettype($decoded),
            'decoded_is_array' => is_array($decoded),
            'decoded_count' => is_array($decoded) ? count($decoded) : null,
        ]);
    }

    private function logReceivablesRaw(Operation $operation, mixed $receivablesData): void
    {
        Log::debug('RRC0021 - unidadesRecebiveis recebido', [
            'operation_id' => $operation->id ?? null,
            'type' => gettype($receivablesData),
            'is_string' => is_string($receivablesData),
            'is_array' => is_array($receivablesData),
            'length' => is_string($receivablesData) ? strlen($receivablesData) : null,
        ]);
    }

    private function logReceivablesInvalid(Operation $operation, string $raw): void
    {
        Log::error('RRC0021 - unidadesRecebiveis inválido após decode', [
            'operation_id' => $operation->id ?? null,
            'raw_preview' => substr($raw, 0, 500),
        ]);
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
