<?php

namespace App\Services\Core;

use App\Models\Core\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActionService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Action::query();

        return $query;
    }

    public function create(Request $request): Action
    {
        $action = Action::create($request->all());

        return $action;
    }

    public function update(Action $action, Request $request): Action
    {
        $action->update($request->all());

        return $action;
    }
}
