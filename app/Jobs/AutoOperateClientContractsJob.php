<?php

namespace App\Jobs;

use App\Handlers\ContractOperationHandler;
use App\Models\Core\BusinessPartner;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AutoOperateClientContractsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private BusinessPartner $client) {}

    public function handle(): void
    {
        $contracts = $this->client->load(['clientContracts.receivables'])->clientContracts;

        foreach ($contracts as $contract) {
            if (!$contract->isExpired() && !$contract->isFinished()) {
                (new ContractOperationHandler($contract, $this->client))->handleContract();
            }
        }
    }
}
