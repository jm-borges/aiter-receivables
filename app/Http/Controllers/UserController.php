<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\GetUsersRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetUsersRequest $request, UserService $userService): JsonResponse
    {
        $query = $userService->filter($request);

        $users = $query->get();

        return response()->json(['data' => UserResource::collection($users)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserService $userService): JsonResponse
    {
        /** @var User $user */
        $user = User::create($request->all());

        return response()->json(['data' => UserResource::make($user), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user,  UserService $userService): JsonResponse
    {
        $user->update($request->all());

        return response()->json(['data' => UserResource::make($user), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
