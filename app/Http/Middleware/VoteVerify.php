<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Vote;

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
            if (!empty($request->id) && $vote = Vote::find($request->id)->first()) {
                if (strtotime($vote->ended_at) - strtotime('now') > 0) {
                    if ($ticket = Ticket::ticket($request->ticket)->first()) {
                        if ($ticket->active == 1 && $ticket->is_used == 0) { // Looks good
                            $request->merge(['type' => 'ticket']);
                            return $next($request); // Vote is valid !
                        }
                        return redirect('error.404')->withErrors('Credential No Found'); // Ticket No Found !
                    }
                }
                if ($userId = $request->user()->id) {
                    $ids = explode("|", $vote->voted_user);
                    if (!in_array($userId, $ids)) {
                        $request->merge(['type' => 'user']);
                        return $next($request); // Vote is valid !
                    }
                }
                return redirect('/vote'); // Vote Expired or User has already voted
            }
            abort(404); // No such vote
        }
        return redirect('/login'); // No ticket or user need to login to vote.
    }
}
