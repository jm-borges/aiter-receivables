<?php

namespace App\Jobs;

use App\Models\Core\Contract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GetContractReceivablesJob implements ShouldQueue
{
    use Queueable;

    protected Contract $contract;

    /**
     * Create a new job instance.
     */
    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
