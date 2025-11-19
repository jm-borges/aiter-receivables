<?php

namespace App\Services;

use App\DataTransferObjects\ContractOperationData;
use App\Enums\ContractStatus;
use App\Enums\OperationStatus;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use Exception;

class ContractOperationResponseService
{
    public function handleOperationResponse(array $data): void
    {
        $identifier = $data['receivableNegociationId'] ?? null;

        if (!$identifier) {
            report(new Exception("Webhook missing receivableNegociationId"));
            return;
        }

        $operation = Operation::with('contract')->find($identifier);

        if (!$operation) {
            report(new Exception("Operation {$identifier} not found"));
            return;
        }

        $this->updateOperation($operation, $data);

        if (!empty($data['cipMessages'])) {
            $this->storeCipMessages($operation, $data['cipMessages']);
        }

        if ($operation->status === OperationStatus::ACCEPTED) {
            $this->updateContract($operation->contract);
            $this->handleAcceptedOperation($operation);
        }
    }

    private function updateOperation(Operation $operation, array $data): void
    {
        $status = strtolower($data['status'] ?? '');

        $operation->update([
            'identdOp'        => $data['operationId'] ?? null,
            'sitRet'          => $status,
            'operation_href'  => $data['operationHref'] ?? null,
            'status'          => $this->mapOperationStatus($status),
        ]);
    }

    private function updateContract(Contract $contract): void
    {
        $contract->update([
            'status' => ContractStatus::ACTIVE,
        ]);
    }

    private function mapOperationStatus(string $status): OperationStatus
    {
        return match ($status) {
            'aceito'   => OperationStatus::ACCEPTED,
            'recusado' => OperationStatus::REFUSED,
            default    => OperationStatus::ERROR,
        };
    }

    private function storeCipMessages(Operation $operation, array $messages): void
    {
        foreach ($messages as $msg) {
            $operation->cipMessages()->create([
                'code'    => $msg['code']    ?? null,
                'content' => $msg['content'] ?? null,
                'field'   => $msg['field']   ?? null,
                'message' => $msg['message'] ?? null,
            ]);
        }
    }

    private function handleAcceptedOperation(Operation $operation): void
    {
        if (!$operation->request_payload) {
            report(new Exception("Operation {$operation->id} missing request payload."));
            return;
        }

        $dto = ContractOperationData::fromArray($operation->request_payload);

        app(PaymentGenerateService::class)->generateInstallments($dto, $operation->contract);
    }
}
