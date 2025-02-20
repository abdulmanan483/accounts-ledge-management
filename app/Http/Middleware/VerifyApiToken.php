<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $apiToken = $request->header('X-API-TOKEN');
        $expectedToken = env('API_TOKEN_SECRET');

        if (!$apiToken || $apiToken !== $expectedToken) {
            $response = [
                'status' => false,
                'message' => "Invalid API Key. Every open request requires a valid API Key to be sent."
            ];
            return response()->json($response, 401);
        }
        return $next($request);
    }
}
