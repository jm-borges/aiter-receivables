<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC002Action
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(DeactivationDto $deactivation): void
    {
        $response = $this->rtmApiClient->makeRequest(
            'post',
            'trade-repository/receivable-units-deactivate',
            $deactivation->toArray(),
            function (Response $response) {
                return $response->json();
            },
        );

        //do something with this
    }
}
