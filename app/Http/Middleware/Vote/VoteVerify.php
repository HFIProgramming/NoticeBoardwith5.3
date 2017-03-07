<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use App\Vote;
use App\Ticket;
use App\Answer;

class VoteVerify
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
		// general Checking
		if (empty($request->ticket) && !Auth::check()) {
			return redirect('/login')->withErrors(['warning' => Lang::get('login.login_required', [
				'process' => 'vote'
			]),]); // No ticket or user need to login to vote.
		}


		//If tickets: the votes must be of the same type.
		if (empty($vote = Vote::find($request->id)) && empty($vote = Ticket::ticket($request->ticket)->first()->voteGroup->votes->first())) { //check if vote exists
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_no_found')]); // Vote No Found
		}

		if (strtotime($vote->ended_at) - strtotime('now') < 0) {
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_expired')]); // Vote Expired
		}

		// Categorize

		// If user use ticket to vote, then go with this check

		if (!empty(Ticket::ticket($request->ticket)->first()) && ($vote->type == 1 || $vote->type == 2)) {
			$ticket = Ticket::ticket($request->ticket)->first();
			if ($ticket->active == 1) { // check if ticket is valid
				$request->merge(['type' => 'ticket']); //将该请求归类到Ticket类型
				return $next($request);
			}
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.ticket_invalid')]); // Ticket Not Valid !
		}

		// If user login to vote, then go with this check
		if (Auth::check() && ($vote->type == 0 || $vote->type == 2)) {
			$request->merge(['type' => 'user']); //将该请求归类到User类型
			return $next($request);
		}
		return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.credential_error')]); // Missing vaild Credential
	}
}
