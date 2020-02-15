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
            return $request->expectsJson()
                    ? abort(403, __('admin.verification_needed'))
                    : Redirect::route('verification');
        }

        return $next($request);
    }
}
