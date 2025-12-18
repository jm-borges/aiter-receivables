<?php

namespace App\Services;

use App\Auxiliary\ContractOperationResultInfo;
use App\DataTransferObjects\ContractOperationData;
use App\Enums\ContractStatus;
use App\Enums\OperationStatus;
use App\Handlers\ContractOperationHandler;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use App\Models\User;
use App\Services\Core\ContractService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ContractOperationService
{
    public function __construct(
        private ContractService $contractService,
    ) {}

    public function execute(ContractOperationData $data): ContractOperationResultInfo
    {
        $partner = $this->getPartner($data);
        $contract = $this->createContract($partner, $data);
        $operation = $this->runOperation($contract, $partner, $data);

        $this->storeRequestPayload($operation, $data);
        $hasError = $this->checkForErrors($operation);
        $this->syncContractStatus($contract, $hasError);

        return new ContractOperationResultInfo(
            contract: $contract,
            operation: $operation,
            hasError: $hasError,
        );
    }

    private function getPartner(ContractOperationData $data): BusinessPartner
    {
        return BusinessPartner::findByDocumentNumber($data->documentNumber)
            ->load('users');
    }

    private function runOperation($contract, $partner, ContractOperationData $data)
    {
        return $this->executeOperation($contract, $partner, $data);
    }

    private function storeRequestPayload($operation, ContractOperationData $data): void
    {
        $operation->update([
            'request_payload' => $data->toArray(),
        ]);
    }

    private function checkForErrors(Operation $operation): bool
    {
        $hasError = $operation->status === OperationStatus::ERROR;

        if ($hasError) {
            report(new Exception(
                'Operação falhou na registradora. Verifique o log de retornos'
            ));
        }

        return $hasError;
    }

    private function syncContractStatus(Contract $contract, bool $hasError): void
    {
        if ($hasError) {
            $contract->update([
                'status' => ContractStatus::ERROR,
            ]);
            return;
        }
    }

    private function executeOperation(Contract $contract, BusinessPartner $partner, ContractOperationData $data)
    {
        return (new ContractOperationHandler($contract, $partner))->dispatchOperation([
            'value' => $data->warrantedValue,
            'negotiation_type' => $data->negotiationType,
        ]);
    }

    private function createContract(BusinessPartner $partner, ContractOperationData $data): Contract
    {
        return $this->contractService->create($this->buildContractData($partner, $data));
    }

    private function buildContractData(BusinessPartner $partner, ContractOperationData $data): array
    {
        $currentUser = Auth::user();
        $users = $partner->users;
        $user = $users->firstWhere('id', $currentUser->id);

        return [
            'status' => ContractStatus::PENDING,
            'client_id' => $partner->id,
            'supplier_id' => $user->supplier()?->id,
            'value' => $data->warrantedValue,
            'negotiation_type' => $data->negotiationType,
            'start_date' => $user?->pivot?->opt_in_start_date,
            'end_date' => $user?->pivot?->opt_in_end_date,
            'uses_registrar_management' => true,
        ];
    }
}
