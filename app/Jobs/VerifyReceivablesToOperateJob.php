<?php

namespace App\Jobs;

use App\Actions\RRC0019Action;
use App\Auxiliary\UpdatedContractInfo;
use App\DataTransferObjects\Nuclea\ConfirmOperationEntidadeRequest;
use App\Enums\OperationStatus;
use App\Models\Core\Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use App\Services\Core\ContractService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class VerifyReceivablesToOperateJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private BusinessPartner $client) {}

    public function handle(): void
    {
        Log::info("[VerifyReceivablesToOperateJob] Iniciando job", [
            'client_id' => $this->client->id,
            'document_number' => $this->client->document_number,
        ]);

        $contracts = $this->client->load(['clientContracts.receivables'])->clientContracts;

        Log::info("[VerifyReceivablesToOperateJob] Contratos carregados", [
            'client_id' => $this->client->id,
            'contracts_count' => $contracts->count(),
        ]);

        foreach ($contracts as $contract) {
            Log::debug("[VerifyReceivablesToOperateJob] Processando contrato", [
                'contract_id' => $contract->id,
            ]);
            if (!$contract->isExpired()) {
                $this->handleContract($contract);
            }
        }

        Log::info("[VerifyReceivablesToOperateJob] Finalizado com sucesso", [
            'client_id' => $this->client->id,
        ]);
    }

    private function handleContract(Contract $contract): void
    {
        $updatedContractInfo = app(ContractService::class)
            ->updateReceivablesInContract($contract);

        $contract = $updatedContractInfo->contract;

        if ($this->operationShouldBeCreated($updatedContractInfo)) {
            Log::info("[VerifyReceivablesToOperateJob] Criando nova operação", [
                'contract_id' => $contract->id,
                'client_id' => $contract->client_id,
            ]);

            $operation = $this->storeNewOperation($contract);

            Log::debug("[VerifyReceivablesToOperateJob] Operação criada", [
                'operation_id' => $operation->id,
                'status' => $operation->status,
            ]);

            $confirmOperationRequestData = $this->getConfirmOperationRequestData($contract, $operation);

            if ($this->isOutsideNegotiationWindow()) {
                $now = now('America/Sao_Paulo');
                $nextWindow = today('America/Sao_Paulo')->setHour(12)->setMinute(0)->setSecond(0);

                if ($now->greaterThan(today('America/Sao_Paulo')->setHour(18))) {
                    $nextWindow->addDay();
                }

                dispatch(new ConfirmRRC0019Job($operation, $confirmOperationRequestData))->delay($nextWindow);
            } else {
                app(RRC0019Action::class)->confirmOperation($operation, $confirmOperationRequestData);
            }

            Log::info("[VerifyReceivablesToOperateJob] Operação enviada", [
                'operation_id' => $operation->id,
            ]);
        } else {
            Log::debug("[VerifyReceivablesToOperateJob] Nenhuma operação necessária", [
                'contract_id' => $contract->id,
                'hasAchievedGoal' => $updatedContractInfo->hasAchievedGoal,
                'thereWerePreviousOperations' => $updatedContractInfo->thereWerePreviousOperations,
            ]);
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
            titulares: $this->buildTitularesInfo($contract),
        );
    }

    private function buildTitularesInfo(Contract $contract): array
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
