<?php

namespace App\Services;

use App\Models\NegotiationWindow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class NegotiationWindowService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = NegotiationWindow::query();

        return $query;
    }

    public function create(Request $request): NegotiationWindow
    {
        $negotiationWindow = NegotiationWindow::create($request->all());

        return $negotiationWindow;
    }

    public function update(NegotiationWindow $negotiationWindow, Request $request): NegotiationWindow
    {
        $negotiationWindow->update($request->all());

        return $negotiationWindow;
    }
}