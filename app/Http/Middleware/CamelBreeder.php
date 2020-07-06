<?php

namespace App\Http\Middleware;

use Closure;

class CamelBreeder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! $request->user()->hasRole('camel-breeder')){
            abort(418);
        }
        return $next($request);
    }
}
