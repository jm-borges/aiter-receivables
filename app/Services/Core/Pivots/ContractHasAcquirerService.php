<?php

namespace App\Services\Core\Pivots;

use App\Models\Core\Pivots\ContractHasAcquirer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContractHasAcquirerService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ContractHasAcquirer::query();

        return $query;
    }

    public function create(Request $request): ContractHasAcquirer
    {
        $contractHasAcquirer = ContractHasAcquirer::create($request->all());

        return $contractHasAcquirer;
    }

    public function update(ContractHasAcquirer $contractHasAcquirer, Request $request): ContractHasAcquirer
    {
        $contractHasAcquirer->update($request->all());

        return $contractHasAcquirer;
    }
}
