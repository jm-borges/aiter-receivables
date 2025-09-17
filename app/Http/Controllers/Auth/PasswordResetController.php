<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RedefinePasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    public function handleReset(Request $request)
    {
        $token = $request->query('token');
        $appScheme =  config('app.schema') . '://reset-password?token=' . $token;
        $webUrl = url('/web-reset-password?token=' . $token);

        return view('password_reset_redirect', [
            'appScheme' => $appScheme,
            'webUrl' => $webUrl,
            'token' => $token,
        ]);
    }

    public function webResetPassword(Request $request)
    {
        $token = $request->query('token');

        return view('password_reset', [
            'token' => $token,
        ]);
    }

    public function updatePassword(RedefinePasswordRequest $request)
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return redirect()->back()->withErrors(['token' => 'Token inválido ou expirado.']);
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Usuário não encontrado.']);
        }

        $user->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect()->route('password.reset.success');
    }

    public function apiUpdatePassword(RedefinePasswordRequest $request): JsonResponse
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return response()->json(['error' => 'Token inválido ou expirado.'], 422);
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 422);
        }

        $user->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return response()->json(['message' => 'Senha redefinida com sucesso.'], 200);
    }

    public function passwordResetSuccessfully(Request $request)
    {
        return view('password_reset_successful', []);
    }
}
