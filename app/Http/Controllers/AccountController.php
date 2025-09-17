<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accounts\GetAccountsRequest;
use App\Http\Requests\Accounts\StoreAccountRequest;
use App\Http\Requests\Accounts\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetAccountsRequest $request, AccountService $accountService): JsonResponse
    {
        $query = $accountService->filter($request);

        $accounts = $query->get();

        return response()->json(['data' => AccountResource::collection($accounts)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request, AccountService $accountService): JsonResponse
    {
        $account = $accountService->create($request);

        return response()->json(['data' => AccountResource::make($account), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account): JsonResponse
    {
        return response()->json(AccountResource::make($account));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account, AccountService $accountService): JsonResponse
    {
        $account = $accountService->update($account, $request);

        return response()->json(['data' => AccountResource::make($account), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account): JsonResponse
    {
        $account->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}