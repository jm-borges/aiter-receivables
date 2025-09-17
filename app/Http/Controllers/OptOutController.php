<?php

namespace App\Http\Controllers;

use App\Http\Requests\OptOuts\GetOptOutsRequest;
use App\Http\Requests\OptOuts\StoreOptOutRequest;
use App\Http\Requests\OptOuts\UpdateOptOutRequest;
use App\Http\Resources\OptOutResource;
use App\Models\OptOut;
use App\Services\OptOutService;
use Illuminate\Http\JsonResponse;

class OptOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetOptOutsRequest $request, OptOutService $optOutService): JsonResponse
    {
        $query = $optOutService->filter($request);

        $optOuts = $query->get();

        return response()->json(['data' => OptOutResource::collection($optOuts)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOptOutRequest $request, OptOutService $optOutService): JsonResponse
    {
        $optOut = $optOutService->create($request);

        return response()->json(['data' => OptOutResource::make($optOut), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(OptOut $optOut): JsonResponse
    {
        return response()->json(OptOutResource::make($optOut));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOptOutRequest $request, OptOut $optOut, OptOutService $optOutService): JsonResponse
    {
        $optOut = $optOutService->update($optOut, $request);

        return response()->json(['data' => OptOutResource::make($optOut), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OptOut $optOut): JsonResponse
    {
        $optOut->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}