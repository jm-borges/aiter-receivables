<?php

namespace App\Http\Controllers;

use App\Http\Requests\NegotiationWindows\GetNegotiationWindowsRequest;
use App\Http\Requests\NegotiationWindows\StoreNegotiationWindowRequest;
use App\Http\Requests\NegotiationWindows\UpdateNegotiationWindowRequest;
use App\Http\Resources\NegotiationWindowResource;
use App\Models\NegotiationWindow;
use App\Services\NegotiationWindowService;
use Illuminate\Http\JsonResponse;

class NegotiationWindowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetNegotiationWindowsRequest $request, NegotiationWindowService $negotiationWindowService): JsonResponse
    {
        $query = $negotiationWindowService->filter($request);

        $negotiationWindows = $query->get();

        return response()->json(['data' => NegotiationWindowResource::collection($negotiationWindows)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNegotiationWindowRequest $request, NegotiationWindowService $negotiationWindowService): JsonResponse
    {
        $negotiationWindow = $negotiationWindowService->create($request);

        return response()->json(['data' => NegotiationWindowResource::make($negotiationWindow), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(NegotiationWindow $negotiationWindow): JsonResponse
    {
        return response()->json(NegotiationWindowResource::make($negotiationWindow));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNegotiationWindowRequest $request, NegotiationWindow $negotiationWindow, NegotiationWindowService $negotiationWindowService): JsonResponse
    {
        $negotiationWindow = $negotiationWindowService->update($negotiationWindow, $request);

        return response()->json(['data' => NegotiationWindowResource::make($negotiationWindow), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NegotiationWindow $negotiationWindow): JsonResponse
    {
        $negotiationWindow->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}