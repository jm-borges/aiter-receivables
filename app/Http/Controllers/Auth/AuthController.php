<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\StartPasswordResetRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\StartPasswordResetNotification;
use App\Services\ChatService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user login and return an access token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'O Login foi feito com sucesso',
            'user' => UserResource::make($user),
        ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        app(ChatService::class)->createFromArray([
            'users_ids' => [$user->id],
            'owner_id' => $user->id,
            'is_group' => false,
            'is_ai' => true,
        ]);

        //TODO: Adicionar créditos de teste (e agendar vencimento em 7 dias)

        return response()->json([
            'token' => $token,
            'message' => 'Usuário registrado com sucesso',
            'user' => UserResource::make($user),
        ], 201);
    }

    public function startPasswordReset(StartPasswordResetRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'error' => 'E-mail não encontrado no sistema',
            ], 404);
        }

        $token = Str::random(60);
        $this->insertPasswordResetToken($request, $token);

        $user->notify(new StartPasswordResetNotification($token));

        return response()->json([
            'message' => 'Password reset link sent successfully.'
        ], 200);
    }

    public function insertPasswordResetToken(Request $request, string $token): void
    {
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
    }
}
