<?php

namespace App\Http\Middleware;

use Closure;

class VerifyFile
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
	    if($request->has('type') && $request->has('fileName')){
	    	if ($request->type === 'image' || $request->type === 'file'){
			    return $next($request);
		    }
	    }
	    abort(500);
    }
}
