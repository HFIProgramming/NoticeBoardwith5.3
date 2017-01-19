<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Ticket;
use App\Vote;


class VoteController extends Controller
{
    //
    public function __construct()
    {
    }

    public function showVotes()
    {
        $votes = Vote::all()->orderBy('ended_at', 'desc')->get();
        return view('vote.index')->withVotes($votes);
    }

    /**
     * show vote pages
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showIndividualVote(Request $request)
    {
        if (!empty($request->ticket) || Auth::check()) {
            $vote = Vote::find($request->id);
            if (!empty($request->id) && $individualVote = $vote->first()) {
                if (strtotime($individualVote->ended_at) - strtotime("now") > 0) {
                    if (!empty($request->ticket)) {
                        return view('vote.individual')->withVote($vote)->withRequest($request); // Ticket User
                    }
                    if ($userId = $request->user()->id) {
                        $ids = explode("|", $individualVote->user_id);
                        if (!in_array($userId, $ids)) {
                            return view('vote.individual')->withVote($vote)->withRequest($request); // Login User
                        }
                        return redirect('/vote'); // Login User Already Vote for this event
                    }
                }
                return redirect('/vote'); // Vote Expired
            }
            abort(404); // No such vote
        }
        return redirect('/login'); // No ticket user need to login to vote.
    }

    /**
     * page to generate tickets
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewTickets()
    {
        return view('vote.ticket');
    }

    /**
     * process generation
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function generateTickets(Request $request)
    {
        if ($errors = Validator::make($request->all(), [
            'prefix' => 'nullable|string',
            'length' => 'required|numeric',
            'vote_id' => 'required|numeric',
            'number' => 'required|numeric',
        ])->validate()
        ) {
            return redirect()->back()->withErrors($errors)->withInput();  // When Validator fails, return errors
        }
        for ($i = 1; $i <= $request->number; $i++) {
            Ticket::create([
                'string' => randomString($request->length, $request->prefix),
                'vote_id' => $request->vote_id,
            ]);
        }
        return redirect()->back();
    }

}
