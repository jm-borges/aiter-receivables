<?php

namespace App\Jobs;

use App\Models\Core\BusinessPartner;
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
            app(ContractService::class)->updateReceivablesInContract($contract);
        }

        //TODO: após essa atualização do contrato de cada recebível, atualiza o valor, caso necessário, das operações
    }
}
