<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Ticket;
use App\Vote;
use App\Option;

class VoteController extends Controller
{
    /**
     * VoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('vote', ['except' => 'showVotes']);
    }

    /**
     * show all votes
     * @return mixed
     */
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
        return view('vote.individual')->withVote(Vote::find($request->id))->withRequest($request);
    }


    /**
     * log the vote
     *
     * @param Request $request
     */
    public function voteHandler(Request $request)
    {
        $this->voteVerify($request); // safety first :)
        $answers = collect($request->answers);
        switch ($request->type) {
            case 'ticket':
                $answers->each(function ($answer, $key) {
                    Answer::create([
                        'option_id' => $answer,
                        'content' => empty($answer->content) ? $answer->content : NULL,
                    ]);
                });
                break;
            case 'user':
                $answers->each(function ($answer, $key) use ($request) {
                    Answer::create([
                        'option_id' => $answer,
                        'user_id' => $request->user()->id,
                        'content' => empty($answer->content) ? $answer->content : NULL,
                    ]);
                });
                break;
        }
        abort(500); // Not gonna happen :(
    }

    /**
     * Verify the vote
     *
     * @param $request
     * @return $this|void
     */
    public function voteVerify($request)
    {
        $answers = collect($request->answer);
        $vote = Vote::find($request->id);
        if ($ticket = Ticket::ticket($request->ticket)->first()) {
            if ($ticket->active == 1 && $ticket->is_used == 0) { // Looks good
                $range = $vote->questions->options->id;
                if (empty($answers->diff($range))) {  // Not out of range
                    $verifyQuestions = $answers->map(function ($answer, $key) {
                        return $answer->question->id;
                    });
                    $unique = $verifyQuestions->unique();
                    $required = collect($vote->questions->where('optional', 0)->id);
                    if (empty($required->diff($unique))) { // Required field has to be filled !
                        $vote->questions->each(function ($question, $key) use ($verifyQuestions) {
                            if ($verifyQuestions->search($question->id) != $question->range || $question->type == 'string') return abort(500); // illegal answers :(
                        });
                    }
                    return redirect()->back()->withInput()->withErrors('Missing Requried');
                }
                return abort(500); // illegal answer :(
            }
            return redirect('error.404')->withErrors("Ticket is not activated or used already");
        }
        return redirect('error.404')->withErrors("Ticket No Found");
    }

}
