<?php

namespace App\Services;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class OperationService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Operation::query();

        return $query;
    }

    public function create(Request $request): Operation
    {
        $operation = Operation::create($request->all());

        return $operation;
    }

    public function update(Operation $operation, Request $request): Operation
    {
        $operation->update($request->all());

        return $operation;
    }
}