<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Receivables\GetReceivablesRequest;
use App\Http\Requests\Receivables\StoreReceivableRequest;
use App\Http\Requests\Receivables\UpdateReceivableRequest;
use App\Http\Resources\ReceivableResource;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;
use Illuminate\Http\JsonResponse;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetReceivablesRequest $request, ReceivableService $receivableService): JsonResponse
    {
        $query = $receivableService->filter($request);

        $receivables = $query->get();

        return response()->json(['data' => ReceivableResource::collection($receivables)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceivableRequest $request, ReceivableService $receivableService): JsonResponse
    {
        $receivable = $receivableService->create($request);

        return response()->json(['data' => ReceivableResource::make($receivable), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Receivable $receivable): JsonResponse
    {
        return response()->json(ReceivableResource::make($receivable));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceivableRequest $request, Receivable $receivable, ReceivableService $receivableService): JsonResponse
    {
        $receivable = $receivableService->update($receivable, $request);

        return response()->json(['data' => ReceivableResource::make($receivable), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receivable $receivable): JsonResponse
    {
        $receivable->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
