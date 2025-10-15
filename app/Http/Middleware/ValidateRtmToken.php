<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRtmToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validToken = config('services.rtm.webhook_token');
        $authHeader = $request->header('Authorization');

        if ($authHeader !== 'Bearer ' . $validToken) {
            return response()->json(['error' => 'Token de autenticação inválido.'], 401);
        }

        return $next($request);
    }
}
