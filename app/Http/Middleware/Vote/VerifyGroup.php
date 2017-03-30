<?php

namespace App\Http\Middleware;

use Closure;
use App\Ticket;
use Illuminate\Support\Facades\Lang;

class VerifyGroup
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
		if (empty($ticket = Ticket::ticket($request->ticket)) || $ticket->active != 1) {
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.ticket_invalid')]);
		}
		return $next($request);
	}
}
