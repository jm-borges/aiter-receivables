<?php

namespace App\Services;

use App\Actions\RRC0013Action;
use App\Enums\OptInStatus;
use App\Enums\OptOutStatus;
use App\Models\Core\OptIn;
use App\Models\Core\OptOut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptOutService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = OptOut::query();

        return $query;
    }

    public function create(Request $request): OptOut
    {
        $optOut = OptOut::create($request->all());

        return $optOut;
    }

    public function update(OptOut $optOut, Request $request): OptOut
    {
        $optOut->update($request->all());

        return $optOut;
    }

    // ---

    public function requestOptOut(OptIn $optIn): OptOut
    {
        $action = app(RRC0013Action::class);

        if (!$optIn->optOut) {
            $optIn->optOut = OptOut::create([
                'opt_in' => $optIn->id,
                'status' => OptOutStatus::PENDING,
                'identd_ctrl_opt_in' => $optIn->identdCtrlOptIn,
                'identdCtrlReqSolicte' => (string) Str::uuid(),
            ]);
        }

        $response = $action->execute(optInIdentifier: $optIn->identdCtrlReqSolicte);

        if ($response['status_code'] === 200) {
            $optIn->update([
                'status' => OptInStatus::OPTED_OUT,
            ]);

            $optIn->optOut->update([
                'identdCtrlOptOut' => $response['body']['identdCtrlOptOut'],
                'status' => OptOutStatus::CONFIRMED,
            ]);
        } else {
            $optIn->optOut->update([
                'status' => OptOutStatus::HAS_ERRORS,
            ]);
        }

        return $optIn->optOut;
    }
}
