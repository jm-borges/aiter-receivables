<?php

namespace App\Services;

use App\Models\OperationHasReceivable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class OperationHasReceivableService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = OperationHasReceivable::query();

        return $query;
    }

    public function create(Request $request): OperationHasReceivable
    {
        $operationHasReceivable = OperationHasReceivable::create($request->all());

        return $operationHasReceivable;
    }

    public function update(OperationHasReceivable $operationHasReceivable, Request $request): OperationHasReceivable
    {
        $operationHasReceivable->update($request->all());

        return $operationHasReceivable;
    }
}