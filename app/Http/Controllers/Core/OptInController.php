<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptIns\GetOptInsRequest;
use App\Http\Requests\OptIns\StoreOptInRequest;
use App\Http\Requests\OptIns\UpdateOptInRequest;
use App\Http\Resources\OptInResource;
use App\Models\Core\OptIn;
use App\Services\Core\OptInService;
use Illuminate\Http\JsonResponse;

class OptInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetOptInsRequest $request, OptInService $optInService): JsonResponse
    {
        $query = $optInService->filter($request);

        $optIns = $query->get();

        return response()->json(['data' => OptInResource::collection($optIns)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptInRequest $request, OptInService $optInService): JsonResponse
    {
        $optIn = $optInService->create($request);

        return response()->json(['data' => OptInResource::make($optIn), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(OptIn $optIn): JsonResponse
    {
        return response()->json(OptInResource::make($optIn));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptInRequest $request, OptIn $optIn, OptInService $optInService): JsonResponse
    {
        $optIn = $optInService->update($optIn, $request);

        return response()->json(['data' => OptInResource::make($optIn), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptIn $optIn): JsonResponse
    {
        $optIn->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
