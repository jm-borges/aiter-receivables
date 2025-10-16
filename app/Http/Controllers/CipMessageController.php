<?php

namespace App\Http\Controllers;

use App\Http\Requests\CipMessages\GetCipMessagesRequest;
use App\Http\Requests\CipMessages\StoreCipMessageRequest;
use App\Http\Requests\CipMessages\UpdateCipMessageRequest;
use App\Http\Resources\CipMessageResource;
use App\Models\CipMessage;
use App\Services\CipMessageService;
use Illuminate\Http\JsonResponse;

class CipMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetCipMessagesRequest $request, CipMessageService $cipMessageService): JsonResponse
    {
        $query = $cipMessageService->filter($request);

        $cipMessages = $query->get();

        return response()->json(['data' => CipMessageResource::collection($cipMessages)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCipMessageRequest $request, CipMessageService $cipMessageService): JsonResponse
    {
        $cipMessage = $cipMessageService->create($request);

        return response()->json(['data' => CipMessageResource::make($cipMessage), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(CipMessage $cipMessage): JsonResponse
    {
        return response()->json(CipMessageResource::make($cipMessage));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCipMessageRequest $request, CipMessage $cipMessage, CipMessageService $cipMessageService): JsonResponse
    {
        $cipMessage = $cipMessageService->update($cipMessage, $request);

        return response()->json(['data' => CipMessageResource::make($cipMessage), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CipMessage $cipMessage): JsonResponse
    {
        $cipMessage->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}