<?php

namespace Kustomrt\LaravelSimpleApiKey\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kustomrt\LaravelSimpleApiKey\Models\ApiKey;

class LaravelSimpleApiKeyMiddleware
{
    const AUTHORIZATION_HEADER = 'X-API-Key';

    public function handle(Request $request, Closure $next)
    {
        // Api Key is missing
        abort_unless($key = $request->header(static::AUTHORIZATION_HEADER), 401);

        // Check if Api Key is valid
        $apiKey = ApiKey::isValid($key);

        // Abort with 403 if it's invalid
        abort_unless($apiKey instanceof ApiKey, 403);

        // Update the last_used_at date
        $apiKey->update([
            'last_used_at' => now()
        ]);

        return $next($request);
    }
}
