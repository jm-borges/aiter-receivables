<?php

namespace App\Services;

use App\Jobs\GetContractReceivablesJob;
use App\Models\Core\Contract;
use App\Models\Receivable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReceivableService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Receivable::query();

        return $query;
    }

    public function create(Request $request): Receivable
    {
        $receivable = Receivable::create($request->all());

        return $receivable;
    }

    public function update(Receivable $receivable, Request $request): Receivable
    {
        $receivable->update($request->all());

        return $receivable;
    }

    // ---

    public function getAllContractsReceivables(): void
    {
        $contracts = Contract::get();

        foreach ($contracts as $contract) {
            dispatch(new GetContractReceivablesJob($contract));
        }
    }
}
