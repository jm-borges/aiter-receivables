<?php

namespace App\Jobs;

use App\Handlers\ContractOperationHandler;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AutoOperateClientContractsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private BusinessPartner $client) {}

    public function handle(): void
    {
        $contracts = $this->client->load(['clientContracts.operations.receivables'])->clientContracts;

        foreach ($contracts as $contract) {
            if ($this->shouldDispatchNewOperation($contract)) {
                (new ContractOperationHandler($contract, $this->client))->dispatchOperation();
            }
        }
    }

    private function shouldDispatchNewOperation(Contract $contract): bool
    {
        return !$contract->isExpired()
            && !$contract->isFinished()
            && !$contract->hasAchievedGoal();
    }
}
