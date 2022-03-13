<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class OnlyHungarian
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale('hu');

        return $next($request);
    }
}
