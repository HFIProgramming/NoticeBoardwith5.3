<?php

namespace App\Http\Middleware;

use Closure;

class GroupVerify
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
		if (empty($ticket = Ticket::ticket($request->ticket)->first()) || $ticket->active != 1) {
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.ticket_invalid')]);
		}
		return $next($request);
	}
}
