<?php

namespace App\Http\Controllers;

use App\Http\Requests\Participants\GetParticipantsRequest;
use App\Http\Requests\Participants\StoreParticipantRequest;
use App\Http\Requests\Participants\UpdateParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;
use App\Services\ParticipantService;
use Illuminate\Http\JsonResponse;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetParticipantsRequest $request, ParticipantService $participantService): JsonResponse
    {
        $query = $participantService->filter($request);

        $participants = $query->get();

        return response()->json(['data' => ParticipantResource::collection($participants)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParticipantRequest $request, ParticipantService $participantService): JsonResponse
    {
        $participant = $participantService->create($request);

        return response()->json(['data' => ParticipantResource::make($participant), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant): JsonResponse
    {
        return response()->json(ParticipantResource::make($participant));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipantRequest $request, Participant $participant, ParticipantService $participantService): JsonResponse
    {
        $participant = $participantService->update($participant, $request);

        return response()->json(['data' => ParticipantResource::make($participant), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant): JsonResponse
    {
        $participant->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}