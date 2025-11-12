<?php

namespace App\Services\Core;

use App\Enums\BusinessPartnerType;
use App\Jobs\RequestOptInJob;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Contract;
use App\Models\Core\OptIn;
use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OptInService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = OptIn::query();

        return $query;
    }

    public function create(Request $request): OptIn
    {
        $optIn = OptIn::create($request->all());

        return $optIn;
    }

    public function update(OptIn $optIn, Request $request): OptIn
    {
        $optIn->update($request->all());

        return $optIn;
    }

    // ---

    public function requestOptInForContract(Contract $contract): void
    {
        $client = $contract->client;

        $contract->acquirers->each(function (BusinessPartner $acquirer) use ($contract, $client) {
            $contract->paymentArrangements->each(function (PaymentArrangement $paymentArrangement) use ($contract, $client, $acquirer) {
                // dispatch(new RequestOptInJob($contract, $client, $acquirer, $paymentArrangement));
            });
        });
    }

    public function requestOptInForClient(BusinessPartner $client): void
    {
        $acquirers = BusinessPartner::where('type', BusinessPartnerType::ACQUIRER)->get();
        $paymentArrangements = PaymentArrangement::get();

        $acquirers->each(function (BusinessPartner $acquirer) use ($client, $paymentArrangements) {
            $paymentArrangements->each(function (PaymentArrangement $paymentArrangement) use ($client, $acquirer) {
                dispatch(new RequestOptInJob($client, $acquirer, $paymentArrangement));
            });
        });
    }
}
