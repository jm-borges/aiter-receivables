<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC033Action
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(ReceivableARRC033Dto $payload): array
    {
        return $this->rtmApiClient->makeRequest('post', 'cip-receivable-schedule-generator-microservice/ipoc', $payload->toArray());
    }
}
