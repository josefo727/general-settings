<?php

namespace Josefo727\GeneralSettings\Http\Middleware;

use Closure;

class TestWebMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
