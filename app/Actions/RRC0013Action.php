<?php

namespace App\Actions;

use App\ApiClients\Nuclea\NucleaApiClient;

class RRC0013Action
{
    private NucleaApiClient $nucleaApiClient;

    public function __construct(NucleaApiClient $nucleaApiClient)
    {
        $this->nucleaApiClient = $nucleaApiClient;
    }

    public function execute(string $optInIdentifier, ?string $identdCtrlReqSolicte = null): array
    {
        return $this->nucleaApiClient->makeRequest(
            'delete',
            'anuencias/' . $optInIdentifier,
            [],
        );
    }
}
