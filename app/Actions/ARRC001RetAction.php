<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC001RetAction
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(): void
    {
        $response = $this->rtmApiClient->makeRequest(
            'get',
            'trade-repository/receivable-unit-responses/search',
            [],
            function (Response $response) {
                return $response->json();
            },
        );

        //do something with this
    }
}
