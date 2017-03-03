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
		// General Checking

		// Find Vote exist
		$vote = Vote::Id($request->id);

		// Login or Ticket
		if (empty($request->ticket) && !Auth::check()){
			return redirect('/login')->withErrors(['warning' => Lang::get('login.login_required', [
				'process' => 'vote'
			]),]); // No ticket or user need to login to vote.
		}

		// Vote Expire
		if (strtotime($vote->ended_at) - strtotime('now') < 0) {
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_expired')]); // Vote Expired
		}

		// Categorize

		// Ticket first!
		if ($ticket = Ticket::ticket($request->ticket)->first() && ($vote->type == 1 || $vote->type == 2)) {
			if ($ticket->active == 1 && $ticket->is_used == 0) { // Looks good
				$request->merge(['type' => 'ticket']);
				return $next($request); // Vote is valid !
			}
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.ticket_invaild')]); // Ticket No Valid !  
		}

		// User
		if (Auth::check() && ($vote->type == 0 || $vote->type == 2)) {
			$userId = $request->user()->id;
			$votedIds = $vote->votedUserIds();
			if ($votedIds->search($userId) == false) {
				$request->merge(['type' => 'user']);
				return $next($request); // Vote is valid !
			}
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.vote_already')]); // User has already voted
		}
		return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.credential_error')]); // Missing vaild Credential  
	}
}
