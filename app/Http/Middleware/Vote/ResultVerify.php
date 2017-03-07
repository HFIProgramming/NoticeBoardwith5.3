<?php

namespace App\Http\Middleware\vote;

use Closure;

class ResultVerify
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
    	// @TODO

        return $next($request);
    }
}
