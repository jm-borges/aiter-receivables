<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Actions\GetActionsRequest;
use App\Http\Requests\Actions\StoreActionRequest;
use App\Http\Requests\Actions\UpdateActionRequest;
use App\Http\Resources\ActionResource;
use App\Models\Core\Action;
use App\Services\Core\ActionService;
use Illuminate\Http\JsonResponse;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetActionsRequest $request, ActionService $actionService): JsonResponse
    {
        $query = $actionService->filter($request);

        $actions = $query->get();

        return response()->json(['data' => ActionResource::collection($actions)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActionRequest $request, ActionService $actionService): JsonResponse
    {
        $action = $actionService->create($request);

        return response()->json(['data' => ActionResource::make($action), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Action $action): JsonResponse
    {
        return response()->json(ActionResource::make($action));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActionRequest $request, Action $action, ActionService $actionService): JsonResponse
    {
        $action = $actionService->update($action, $request);

        return response()->json(['data' => ActionResource::make($action), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action): JsonResponse
    {
        $action->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
