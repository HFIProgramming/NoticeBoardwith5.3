<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AvertBlacklistUser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->user()->blacklisted != false) {
			abort(403, __('auth.blacklisted'));
		}

		return $next($request);


	}
}
