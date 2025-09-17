<?php

namespace App\Services;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class MerchantService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Merchant::query();

        return $query;
    }

    public function create(Request $request): Merchant
    {
        $merchant = Merchant::create($request->all());

        return $merchant;
    }

    public function update(Merchant $merchant, Request $request): Merchant
    {
        $merchant->update($request->all());

        return $merchant;
    }
}