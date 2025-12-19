<?php

namespace App\Services\Core;

use App\Actions\RRC0013Action;
use App\Enums\OptInStatus;
use App\Enums\OptOutStatus;
use App\Models\Core\OptIn;
use App\Models\Core\OptOut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;

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
        $this->ensureOptOutExists($optIn);

        $response = $this->executeOptOutAction($optIn);

        $this->handleOptOutResponse($optIn, $response);

        return $optIn->optOut;
    }

    private function ensureOptOutExists(OptIn $optIn): void
    {
        if (!$optIn->optOut) {
            $optIn->optOut = OptOut::create([
                'opt_in_id' => $optIn->id,
                'status' => OptOutStatus::PENDING,
                'identd_ctrl_opt_in' => $optIn->identdCtrlOptIn,
                'identdCtrlReqSolicte' => (string) Str::uuid(),
            ]);
        }
    }

    private function executeOptOutAction(OptIn $optIn): array
    {
        $action = app(RRC0013Action::class);
        return $action->execute(optInIdentifier: $optIn->identdCtrlOptIn);
    }

    private function handleOptOutResponse(OptIn $optIn, array $response): void
    {
        if ($response['status_code'] !== 200) {
            $optIn->optOut->update([
                'status' => OptOutStatus::HAS_ERRORS,
            ]);
            return;
        }

        $body = $response['body'] ?? [];

        if (!isset($body['identdCtrlOptOut'])) {
            $optIn->optOut->update([
                'status' => OptOutStatus::HAS_ERRORS,
            ]);
            throw new RuntimeException('Resposta inválida: campo "identdCtrlOptOut" não encontrado.');
        }

        $optIn->update(['status' => OptInStatus::OPTED_OUT]);

        $optIn->optOut->update([
            'identdCtrlOptOut' => $body['identdCtrlOptOut'],
            'status' => OptOutStatus::CONFIRMED,
        ]);
    }
}
