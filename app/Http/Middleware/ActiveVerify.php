<?php

namespace App\Http\Middleware;

use Closure;

class ActiveVerify
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
        if ($request->user()->active == 0){
            return redirect('/completion');
        }
        return $next($request);
    }
}
