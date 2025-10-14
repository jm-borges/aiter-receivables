<?php

namespace App\Services\Core\Pivots;

use App\Models\Core\Pivots\ContractHasReceivable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContractHasReceivableService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ContractHasReceivable::query();

        return $query;
    }

    public function create(Request $request): ContractHasReceivable
    {
        $contractHasReceivable = ContractHasReceivable::create($request->all());

        return $contractHasReceivable;
    }

    public function update(ContractHasReceivable $contractHasReceivable, Request $request): ContractHasReceivable
    {
        $contractHasReceivable->update($request->all());

        return $contractHasReceivable;
    }
}
