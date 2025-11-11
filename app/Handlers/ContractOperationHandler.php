<?php

namespace App\Handlers;

use App\Actions\RRC0019Action;
use App\DataTransferObjects\Nuclea\ConfirmOperationEntidadeRequest;
use App\Enums\OperationStatus;
use App\Enums\RRC0019ObjectType;
use App\Models\Core\Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;

class ContractOperationHandler
{
    public function __construct(
        private Contract $contract,
        private BusinessPartner $client,
    ) {}

    public function dispatchOperation(?array $data = null): void
    {
        $operation = $this->storeNewOperation();
        $confirmOperationRequestData = $this->getConfirmOperationRequestData($operation, $data);
        app(RRC0019Action::class)->confirmOperation($operation, $confirmOperationRequestData);
    }

    private function storeNewOperation(): Operation
    {
        return Operation::create([
            'contract_id' => $this->contract->id,
            'action_id' => Action::getByName('RRC0019')?->id,
            'status' => OperationStatus::PENDING,
        ]);
    }

    private function getConfirmOperationRequestData(Operation $operation, ?array $data = null): ConfirmOperationEntidadeRequest
    {
        return new ConfirmOperationEntidadeRequest(
            tpObj: RRC0019ObjectType::GESTAO_REGISTRADORA->value,
            identdNegcRecbvl: $operation->id,
            indrTpNegc: $this->contract->isAutomatic() ? $this->contract->negotiation_type->value : $data['negotiation_type']->value,
            dtVencOp: $this->contract->end_date->format('Y-m-d'),
            vlrGar: $this->contract->isAutomatic() ? $this->contract->pendingValue() : $data['value'],
            vlrTotLimOuSldDevdr: $this->contract->isAutomatic() ? $this->contract->pendingValue() : $data['value'],
            indrGestER: 'S',
            indrRegrDivs: 'V',
            indrAlcancContrtoCreddrSub: 'G',
            indrActeIncondlOp: 'N',
            indrActeUniddRecbvlReserv: 'C',
            indrAutcCess: 'N',
            titulares: $this->buildHoldersInfo(),
        );
    }

    private function buildHoldersInfo(): array
    {
        return [
            [
                'cnpjOuCnpjBaseOuCpfTitlar' => substr($this->client->document_number, 0, 8),
                'vlrOuPercTotOpUniddRecbvl' => $this->contract->pendingValue(),
                'dtIniOp' => now()->addDay()->format('Y-m-d'),
                'dtFimOp' => $this->contract->end_date->format('Y-m-d'),
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
}
