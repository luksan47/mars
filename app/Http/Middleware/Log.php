<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as SystemLog;

class Log
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
        if (Auth::check() && $request->isMethod('post')) {
            SystemLog::debug('User #'.Auth::user()->id.' sent request: path='
                .$request->path().'&'
                .http_build_query($request->input()));
        }

        return $next($request);
    }
}
