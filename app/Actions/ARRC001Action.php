<?php

namespace App\Actions;

use App\ApiClients\Rtm\RtmApiClient;
use Illuminate\Http\Client\Response;

class ARRC001Action
{
    private RtmApiClient $rtmApiClient;

    public function __construct(RtmApiClient $rtmApiClient)
    {
        $this->rtmApiClient = $rtmApiClient;
    }

    public function execute(ReceivableUnitDto $receivableUnit): void
    {
        $response = $this->rtmApiClient->makeRequest(
            'post',
            'trade-repository/receivable-units',
            $receivableUnit->toArray(),
            function (Response $response) {
                return $response->json();
            },
        );

        //do something with this
    }
}
