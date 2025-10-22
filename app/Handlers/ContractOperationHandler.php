<?php

namespace App\Handlers;

use App\Actions\RRC0019Action;
use App\Auxiliary\UpdatedContractInfo;
use App\DataTransferObjects\Nuclea\ConfirmOperationEntidadeRequest;
use App\Enums\OperationStatus;
use App\Jobs\ConfirmRRC0019Job;
use App\Models\Core\Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use App\Services\Core\ContractService;

class ContractOperationHandler
{
    public function __construct(
        private Contract $contract,
        private BusinessPartner $client,
    ) {}

    public function handleContract(): void
    {
        $updatedContractInfo = app(ContractService::class)
            ->updateReceivablesInContract($this->contract);

        $contract = $updatedContractInfo->contract;

        if ($this->operationShouldBeCreated($updatedContractInfo)) {
            $this->dispatchOperation($contract);
        }
    }

    private function dispatchOperation(Contract $contract): void
    {
        $operation = $this->storeNewOperation($contract);

        $confirmOperationRequestData = $this->getConfirmOperationRequestData($contract, $operation);

        if ($this->isOutsideNegotiationWindow()) {
            $now = now('America/Sao_Paulo');
            $nextWindow = today('America/Sao_Paulo')->setHour(12)->setMinute(0)->setSecond(0);

            if ($now->greaterThan(today('America/Sao_Paulo')->setHour(18))) {
                $nextWindow->addDay();
            }

            dispatch(new ConfirmRRC0019Job($contract, $operation, $confirmOperationRequestData))->delay($nextWindow);
        } else {
            app(RRC0019Action::class)->confirmOperation($operation, $confirmOperationRequestData);
        }
    }

    private function isOutsideNegotiationWindow(): bool
    {
        $now = now('America/Sao_Paulo');
        $start = today('America/Sao_Paulo')->setHour(12);
        $end = today('America/Sao_Paulo')->setHour(18);

        return $now->lt($start) || $now->gt($end);
    }

    private function storeNewOperation(Contract $contract): Operation
    {
        return Operation::create([
            'contract_id' => $contract->id,
            'action_id' => Action::getByName('RRC0019')?->id,
            'status' => OperationStatus::PENDING,
        ]);
    }

    private function getConfirmOperationRequestData(Contract $contract, Operation $operation): ConfirmOperationEntidadeRequest
    {
        return new ConfirmOperationEntidadeRequest(
            tpObj: 'E',
            identdNegcRecbvl: $operation->id,
            indrTpNegc: 'OG',
            dtVencOp: $contract->end_date->format('Y-m-d'),
            vlrGar: $contract->value,
            vlrTotLimOuSldDevdr: $contract->value,
            indrGestER: 'S',
            indrRegrDivs: 'V',
            indrAlcancContrtoCreddrSub: 'G',
            indrActeIncondlOp: 'N',
            indrActeUniddRecbvlReserv: 'C',
            indrAutcCess: 'N',
            titulares: $this->buildHoldersInfo($contract),
        );
    }

    private function buildHoldersInfo(Contract $contract): array
    {
        return [
            [
                'cnpjOuCnpjBaseOuCpfTitlar' => substr($this->client->document_number, 0, 8),
                'vlrOuPercTotOpUniddRecbvl' => $contract->value,
                'dtIniOp' => now()->addDay()->format('Y-m-d'),
                'dtFimOp' => $contract->end_date->format('Y-m-d'),
                'cnpjOuCpfTitlarCt' => config('altri.cnpj'),
                'ispbBcoRecbdr' => config('altri.bank_ispb'),
                'tpCt' => config('altri.account_type'),
                'ctPgto' => config('altri.account_number'),
                'usuariosFinaisRecebedores' => [
                    [
                        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $this->client->document_number,
                    ]
                ],
            ],
        ];
    }

    private function operationShouldBeCreated(UpdatedContractInfo $info): bool
    {
        return $info->hasAchievedGoal && ! $info->thereWerePreviousOperations;
    }
}
