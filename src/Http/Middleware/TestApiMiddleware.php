<?php

namespace Josefo727\GeneralSettings\Http\Middleware;

use Closure;

class TestApiMiddleware
{
    /**
     * @return mixed
     * @param mixed $request
     * @param Closure(): void $next
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
