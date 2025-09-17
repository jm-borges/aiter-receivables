<?php

namespace App\Services;

use App\Models\BusinessPartner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class BusinessPartnerService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = BusinessPartner::query();

        return $query;
    }

    public function create(Request $request): BusinessPartner
    {
        $businessPartner = BusinessPartner::create($request->all());

        return $businessPartner;
    }

    public function update(BusinessPartner $businessPartner, Request $request): BusinessPartner
    {
        $businessPartner->update($request->all());

        return $businessPartner;
    }
}