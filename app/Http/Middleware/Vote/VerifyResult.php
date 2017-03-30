<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Ticket;
use App\Vote;
use Illuminate\Support\Facades\Lang;

class VerifyResult
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
		// @TODO Please Check
		if (empty($request->ticket) && !Auth::check()) {
			return redirect('/login')->withErrors(['warning' => Lang::get('login.login_required', [
				'process' => 'vote'
			]),]); // No ticket or user need to login to vote.
		}

		if (empty($vote = Vote::find($request->id))) { //check if vote exists
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_no_found')]); // Vote No Found
		}

		if ($vote->show_result != 1){
			return view('vote.thanks'); // Vote result set not shown
		}

		if (!empty($ticket = Ticket::ticket($request->ticket)) && ($vote->type == 1 || $vote->type == 2)) {
			if ($ticket->active == 0){	
				return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.ticket_invalid')]); // Ticket is not valid
			}
			if ($ticket->isTicketUsed($vote->id)) {
				return $next($request);  // Ticket has used for this Vote !
			}
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_first')]); // Ticket is not used !
		}

		// If user login to vote, then go with this check
		if ($user = Auth::user() && ($vote->type == 0 || $vote->type == 2)) {
			if ($user->isUserVoted($vote->id)) {
				return $next($request);
			}
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.user_not_voted')]); // User has not voted !
		}

		return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.credential_error')]); // Credential invalid
	}
  
}
