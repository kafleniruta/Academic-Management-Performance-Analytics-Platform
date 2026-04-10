<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests as Middleware;

class HandlePrecognitiveRequests extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return $next($request);
    }
}
