<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = config('api.token');
        if ($request->header('Authorization') !== 'Bearer ' . $apiToken) {
            return response('Unauthorized', 401);
        }

        return $next($request);
    }
}
