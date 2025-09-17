<?php

namespace App\Services;

use App\Models\ReceivableMovement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class ReceivableMovementService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ReceivableMovement::query();

        return $query;
    }

    public function create(Request $request): ReceivableMovement
    {
        $receivableMovement = ReceivableMovement::create($request->all());

        return $receivableMovement;
    }

    public function update(ReceivableMovement $receivableMovement, Request $request): ReceivableMovement
    {
        $receivableMovement->update($request->all());

        return $receivableMovement;
    }
}