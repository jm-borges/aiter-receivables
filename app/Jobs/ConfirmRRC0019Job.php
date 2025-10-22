<?php

namespace App\Jobs;

use App\Actions\RRC0010Action;
use App\Actions\RRC0019Action;
use App\DataTransferObjects\Nuclea\ConfirmOperationRequest;
use App\Handlers\ContractOperationHandler;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\Operation;
use App\Models\Core\PaymentArrangement;
use App\Services\Core\ContractService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ConfirmRRC0019Job implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Contract $contract,
        private Operation $operation,
        private ConfirmOperationRequest $confirmOperationRequestData,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = $this->contract->client;
        /*      $contract->receivables = $contract->receivables()->get();

            $updatedContractInfo = app(ContractService::class)
                ->updateReceivablesInContract($contract);

            $contract = $updatedContractInfo->contract; */
        //  (new ContractOperationHandler($contract, $client))->handleContract();
    }
}
