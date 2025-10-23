<?php

namespace App\Services\Core;

use App\Models\Core\CipMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CipMessageService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = CipMessage::query();

        return $query;
    }

    public function create(Request $request): CipMessage
    {
        $cipMessage = CipMessage::create($request->all());

        return $cipMessage;
    }

    public function update(CipMessage $cipMessage, Request $request): CipMessage
    {
        $cipMessage->update($request->all());

        return $cipMessage;
    }
}
