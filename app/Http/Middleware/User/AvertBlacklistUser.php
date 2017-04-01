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
		if (Auth::check() && Auth::user()->blacklisted == false) {
			return $next($request);
		}

		abort(403, __('auth.blacklisted'));

	}
}
