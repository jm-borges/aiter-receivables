<?php

namespace App\Jobs;

use App\Handlers\ContractOperationHandler;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConfirmRRC0019Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $operationId;
    private int $contractId;
    private int $clientId;
    private ?array $data;

    public function __construct(int $operationId, int $contractId, int $clientId, ?array $data)
    {
        $this->operationId = $operationId;
        $this->contractId  = $contractId;
        $this->clientId    = $clientId;
        $this->data        = $data;
    }

    public function handle(ContractOperationHandler $handler)
    {
        $operation = Operation::findOrFail($this->operationId);
        $contract  = Contract::findOrFail($this->contractId);
        $client    = BusinessPartner::findOrFail($this->clientId);

        $handler = new ContractOperationHandler($contract, $client);

        $handler->executeOperation($operation, $this->data);
    }
}
