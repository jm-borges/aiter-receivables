<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC036Action
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(ARRC036RequestDto $payload): array
    {
        return $this->rtmApiClient->makeRequest('post', 'generator-repository/banking-domicile-lot', $payload->toArray());
    }
}
