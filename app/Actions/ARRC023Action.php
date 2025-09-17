<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC023Action
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(ARRC023RequestDto $payload): array
    {
        return $this->rtmApiClient->makeRequest('post', 'cip-receivable-schedule-generator-microservice/cancel-operations-lot', $payload->toArray());
    }
}
