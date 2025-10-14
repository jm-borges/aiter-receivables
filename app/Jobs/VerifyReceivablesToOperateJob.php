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

class VerifyReceivablesToOperateJob implements ShouldQueue
{
    use Queueable;

    private BusinessPartner $client;

    /**
     * Create a new job instance.
     */
    public function __construct(BusinessPartner $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contracts = $this->client->load(['contracts.receivables'])->contracts;

        foreach ($contracts as $contract) {
            $this->handleContract($contract);
        }
    }

    private function handleContract(Contract $contract): void
    {
        $updatedContractInfo = app(ContractService::class)->updateReceivablesInContract($contract);
        $contract = $updatedContractInfo->contract;

        if ($this->operationShouldBeCreated($updatedContractInfo)) {
            $operation = $this->storeNewOperation($contract);
            $confirmOperationRequestData = $this->getConfirmOperationRequestData($contract, $operation);
            app(RRC0019Action::class)->confirmOperation($operation, $confirmOperationRequestData);
        }
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
            //OBS: Seria interessante usar enums para cada campo para garantir consistência e erros de digitação
            tpObj: 'E',
            identdNegcRecbvl: $operation->id,
            indrTpNegc: 'OG',
            dtVencOp: $contract->end_date,
            vlrTotLimOuSldDevdr: $contract->value,
            indrGestER: 'S',
            indrRegrDivs: 'V',
            indrAlcancContrtoCreddrSub: 'G',
            indrActeIncondlOp: 'N',
            indrActeUniddRecbvlReserv: 'C',
            titulares: $this->buildTitularesInfo($contract),
        );
    }

    private function buildTitularesInfo(Contract $contract): array
    {
        return  [
            [
                'cnpjOuCnpjBaseOuCpfTitlar' =>  config('altri.cnpj'),
                'vlrOuPercTotOpUniddRecbvl' => $contract->value,
                'dtIniOp' => $contract->start_date,
                'dtFimOp' => $contract->end_date,
                'cnpjOuCpfTitlarCt' =>  config('altri.cnpj'),
                "ispbBcoRecbdr" => config('altri.bank_ispb'),
                "tpCt" =>  config('altri.account_type'),
                "ctPgto" => config('altri.account_number'),
                'usuariosFinaisRecebedores' => [
                    [
                        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $this->client->document_number,
                    ]
                ],
            ],
        ];
    }

    private function operationShouldBeCreated(UpdatedContractInfo $updatedContractInfo): bool
    {
        $hasAchivedGoal = $updatedContractInfo->hasAchievedGoal;
        $thereWerePreviousOperations = $updatedContractInfo->thereWerePreviousOperations;

        if (!$hasAchivedGoal) {
            return false;
        }

        if (!$thereWerePreviousOperations) {
            return true;
        }

        //FICA FALTANDO O CENÁRIO EM QUE OS RECEBIVEIS DISPONIVEIS MUDAM, DE FORMA QUE O OBJETIVO DO CONTRATO É ATINGIDO, MAS JÁ HOUVERAM OPERAÇÕES ANTERIOR
        //AGUARDAR RETORNO DA NUCLEA

        return false;
    }
}
