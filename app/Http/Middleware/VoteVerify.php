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
		if (!empty($request->ticket) || Auth::check()) {
			if (!empty($request->id) && $vote = Vote::Id($request->id)->first()) {
				if (strtotime($vote->ended_at) - strtotime('now') > 0) {
					if ($ticket = Ticket::ticket($request->ticket)->first()) {
						if ($ticket->active == 1 && $ticket->is_used == 0) { // Looks good
							$request->merge(['type' => 'ticket']);
							return $next($request); // Vote is valid !
						}
						return redirect('/404')->withErrors(['warning' => Lang::get('vote.credential_error')]); // Ticket No Valid !
					}
					if (Auth::check()) {
						$userId = $request->user()->id;
						$votedIds = $vote->votedUserIds();
						if (!in_array($userId, $votedIds)) {
							$request->merge(['type' => 'user']);
							return $next($request); // Vote is valid !
						}
						return redirect('/404')->withErrors(['warning' => Lang::get('vote.vote_already')]); // User has already voted
					}
					return redirect('/404')->withErrors(['warning' => Lang::get('vote.credential_error')]); // Ticket No Valid !
				}
				return redirect('/404')->withErrors(['warning' => Lang::get('vote.vote_expired')]); // Vote Expired
			}
			return redirect('/404')->withErrors(['warning' => Lang::get('vote.vote_no_found')]); // Vote No Found
		}
		return redirect('login')->withErrors(['warning' => Lang::get('login.login_required', [
				'process' => 'vote'
			]),]); // No ticket or user need to login to vote.
	}
}
