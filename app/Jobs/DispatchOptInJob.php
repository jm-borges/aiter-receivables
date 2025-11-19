<?php

namespace App\Jobs;

use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Services\Core\OptInService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchOptInJob implements ShouldQueue
{
    use Queueable;


    public function __construct(
        private BusinessPartner $client,
    ) {}

    public function handle(OptInService $optInService)
    {
        $optInService->requestOptInForClient($this->client);
    }
}
