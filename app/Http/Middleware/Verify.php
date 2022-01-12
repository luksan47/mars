<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class Verify
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
        if (! $request->user() ||
            ($request->user() && ! $request->user()->verified)) {
            if ($request->user()->isCollegist()) {
                return Redirect::route('application');
            } else {
                return Redirect::route('verification');
            }
        }

        return $next($request);
    }
}
