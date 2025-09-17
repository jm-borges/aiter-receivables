<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class ContractService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Contract::query();

        return $query;
    }

    public function create(Request $request): Contract
    {
        $contract = Contract::create($request->all());

        return $contract;
    }

    public function update(Contract $contract, Request $request): Contract
    {
        $contract->update($request->all());

        return $contract;
    }
}