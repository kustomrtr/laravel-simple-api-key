<?php

namespace Kustomrt\LaravelSimpleApiKey\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaravelSimpleApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Perform action

        abort_unless($request->bearerToken(), 401);

        abort(403);

        return $next($request);
    }
}
