<?php

namespace App\Services\Core;

use App\Models\Core\BusinessPartner;
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

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($search = $request->get('search')) {
            $normalized = removeSpecialCharacters($search);

            $query->where(function ($q) use ($search, $normalized) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('fantasy_name', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$normalized}%")
                    ->orWhere('base_document_number', 'like', "%{$normalized}%");
            });
        }

        return $query->orderBy('name');
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
