<?php

namespace App\Services;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class ParticipantService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Participant::query();

        return $query;
    }

    public function create(Request $request): Participant
    {
        $participant = Participant::create($request->all());

        return $participant;
    }

    public function update(Participant $participant, Request $request): Participant
    {
        $participant->update($request->all());

        return $participant;
    }
}