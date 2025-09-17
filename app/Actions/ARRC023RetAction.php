<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC023RetAction
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(): array
    {
        return $this->rtmApiClient->makeRequest('get', 'cip-receivable-unit-microservice/arrc023-responses/search', []);
    }
}
