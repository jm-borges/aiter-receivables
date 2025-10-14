<?php

namespace App\Http\Controllers;

use App\Http\Requests\ARRC018Responses\GetARRC018ResponsesRequest;
use App\Http\Requests\ARRC018Responses\StoreARRC018ResponseRequest;
use App\Http\Requests\ARRC018Responses\UpdateARRC018ResponseRequest;
use App\Http\Resources\ARRC018ResponseResource;
use App\Models\ARRC018Response;
use App\Services\ARRC018ResponseService;
use Illuminate\Http\JsonResponse;

class ARRC018ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetARRC018ResponsesRequest $request, ARRC018ResponseService $aRRC018ResponseService): JsonResponse
    {
        $query = $aRRC018ResponseService->filter($request);

        $aRRC018Responses = $query->get();

        return response()->json(['data' => ARRC018ResponseResource::collection($aRRC018Responses)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreARRC018ResponseRequest $request, ARRC018ResponseService $aRRC018ResponseService): JsonResponse
    {
        $aRRC018Response = $aRRC018ResponseService->create($request);

        return response()->json(['data' => ARRC018ResponseResource::make($aRRC018Response), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ARRC018Response $aRRC018Response): JsonResponse
    {
        return response()->json(ARRC018ResponseResource::make($aRRC018Response));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateARRC018ResponseRequest $request, ARRC018Response $aRRC018Response, ARRC018ResponseService $aRRC018ResponseService): JsonResponse
    {
        $aRRC018Response = $aRRC018ResponseService->update($aRRC018Response, $request);

        return response()->json(['data' => ARRC018ResponseResource::make($aRRC018Response), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ARRC018Response $aRRC018Response): JsonResponse
    {
        $aRRC018Response->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}