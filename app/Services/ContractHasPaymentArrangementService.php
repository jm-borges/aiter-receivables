<?php

namespace App\Services;

use App\Models\ContractHasPaymentArrangement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class ContractHasPaymentArrangementService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ContractHasPaymentArrangement::query();

        return $query;
    }

    public function create(Request $request): ContractHasPaymentArrangement
    {
        $contractHasPaymentArrangement = ContractHasPaymentArrangement::create($request->all());

        return $contractHasPaymentArrangement;
    }

    public function update(ContractHasPaymentArrangement $contractHasPaymentArrangement, Request $request): ContractHasPaymentArrangement
    {
        $contractHasPaymentArrangement->update($request->all());

        return $contractHasPaymentArrangement;
    }
}