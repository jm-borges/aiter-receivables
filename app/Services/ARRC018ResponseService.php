<?php

namespace App\Services;

use App\Models\ARRC018Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class ARRC018ResponseService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = ARRC018Response::query();

        return $query;
    }

    public function create(Request $request): ARRC018Response
    {
        $aRRC018Response = ARRC018Response::create($request->all());

        return $aRRC018Response;
    }

    public function update(ARRC018Response $aRRC018Response, Request $request): ARRC018Response
    {
        $aRRC018Response->update($request->all());

        return $aRRC018Response;
    }
}