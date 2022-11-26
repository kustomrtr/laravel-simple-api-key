<?php

namespace Kustomrt\LaravelSimpleApiKey\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;

class LaravelSimpleApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Api Key is missing
        abort_unless($key = $request->bearerToken(), 401);

        // Check if Api Key is valid
        $apiKey = ApiKey::isValid($key);
        abort_unless($apiKey instanceof ApiKey, 403);

        $apiKey->update([
            'last_used_at' => now()
        ]);

        return $next($request);
    }
}
