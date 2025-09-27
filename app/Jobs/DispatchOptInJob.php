<?php

namespace App\Jobs;

use App\Models\Core\Contract;
use App\Services\Core\OptInService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchOptInJob implements ShouldQueue
{
    use Queueable;

    protected Contract $contract;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function handle(OptInService $optInService)
    {
        $optInService->requestOptInForContract($this->contract);
    }
}
