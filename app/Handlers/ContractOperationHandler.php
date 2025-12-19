<?php

namespace App\Handlers;

use App\Actions\RRC0019Action;
use App\DataTransferObjects\Nuclea\ConfirmOperationEntidadeRequest;
use App\Enums\NegotiationType;
use App\Enums\OperationStatus;
use App\Enums\RRC0019ObjectType;
use App\Jobs\ConfirmRRC0019Job;
use App\Models\Core\Action;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use Carbon\CarbonInterface;

class ContractOperationHandler
{
    public function __construct(
        private Contract $contract,
        private BusinessPartner $client,
    ) {}

    public function dispatchOperation(?array $data = null): Operation
    {
        $operation = $this->storeNewOperation();
        $now = now();

        $runAt = $this->determineRunAt($now);

        $operation->update([
            'scheduled_at' => $runAt,
        ]);

        ConfirmRRC0019Job::dispatch(
            $operation->id,
            $this->contract->id,
            $this->client->id,
            $data
        )->delay($runAt);

        return $operation;
    }

    private function determineRunAt(CarbonInterface $now): CarbonInterface
    {
        return isInsideWindow($now)
            ? $now
            : nextWindowDateTime();
    }

    public function executeOperation(Operation $operation, ?array $data = null): void
    {
        $dto = $this->prepareRequestDto($operation, $data);

        app(RRC0019Action::class)
            ->confirmOperation($operation, $dto);
    }

    private function storeNewOperation(): Operation
    {
        return Operation::create([
            'supplier_id'  => $this->contract->supplier_id,
            'contract_id'  => $this->contract->id,
            'action_id'    => Action::getByName('RRC0019')?->id,
            'status'       => OperationStatus::PENDING,
        ]);
    }

    /**
     * Monta o DTO enviado à Nuclea.
     */
    private function prepareRequestDto(Operation $operation, array $data): ConfirmOperationEntidadeRequest
    {
        $isGravame = $data['negotiation_type'] === NegotiationType::GRAVAME->value;

        $dto = new ConfirmOperationEntidadeRequest(
            tpObj: RRC0019ObjectType::GESTAO_REGISTRADORA->value,
            identdNegcRecbvl: $operation->id,
            indrTpNegc: $data['negotiation_type'],
            dtVencOp: $this->contract->end_date->format('Y-m-d'),
            vlrTotLimOuSldDevdr: $data['value'],
            indrGestER: 'S',
            indrRegrDivs: 'V',
            indrAlcancContrtoCreddrSub: 'G',
            indrActeIncondlOp: 'N',
            indrActeUniddRecbvlReserv: 'N',
            titulares: $this->buildHoldersInfo()
        );

        if ($isGravame) {
            $dto->vlrGar = $data['value'];
        }

        return $dto;
    }

    /**
     * Info dos titulares (inclui credor, recebedor, final, etc.)
     */
    private function buildHoldersInfo(): array
    {
        return [
            [
                'cnpjOuCnpjBaseOuCpfTitlar' => substr($this->client->document_number, 0, 8),
                'vlrOuPercTotOpUniddRecbvl' => $this->contract->pendingValue(),
                'dtIniOp'                   => now()->addDay()->format('Y-m-d'),
                'dtFimOp'                   => $this->contract->end_date->format('Y-m-d'),
                'cnpjOuCpfTitlarCt'         => config('altri.cnpj'),
                'ispbBcoRecbdr'             => config('altri.bank_ispb'),
                'tpCt'                      => config('altri.account_type'),
                'ctPgto'                    => config('altri.account_number'),
                'usuariosFinaisRecebedores' => [
                    [
                        'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => $this->client->document_number,
                    ]
                ],
            ],
        ];
    }
}
