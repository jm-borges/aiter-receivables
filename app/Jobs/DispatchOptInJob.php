<?php

namespace App\Jobs;

use App\Models\Core\BusinessPartner;
use App\Models\User;
use App\Services\Core\OptInService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchOptInJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $user,
        private BusinessPartner $client,
    ) {}

    public function handle(OptInService $optInService)
    {
        $optInService->requestOptInForClient($this->user, $this->client);
    }
}
