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
        $votes = Vote::with('questions')->orderBy('ended_at', 'desc')->get();
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
     * Vote handler :)
     *
     * @TODO String type Answer still Need Further Step
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function voteHandler(Request $request)
    {
        $answers = collect($request->answer);
        $vote = Vote::find($request->id);
        if ($vote = $this->voteVerify($answers, $vote)) ;// Safety First :)
        switch ($request->type) {
            case 'ticket':
                $answers->each(function ($answer, $key) {
                    Answer::create([
                        'option_id' => $answer,
                        'content' => empty($answer->content) ? $answer->content : NULL,
                    ]);
                });
                $ticket = Ticket::ticket($request->ticket)->first();
                $ticket->is_used = 1;  // Mark as used
                if ($ticket->save()) {
                    return view('vote.success');
                }
                abort(500); // Something goes wrong!
                break;
            case 'user':
                $answers->each(function ($answer, $key) use ($request) {
                    Answer::create([
                        'option_id' => $answer,
                        'user_id' => $request->user()->id,
                        'content' => empty($answer->content) ? $answer->content : NULL,
                    ]);
                });
                $vote = $vote->first();
                $vote->voted_user .= '|' . $request->user()->id;
                if ($vote->save()) {
                    return view('vote.success');
                }
                abort(500);  // Something goes wrong !
                break;
        }
        abort(500); // Not gonna happen :(
    }


    /**
     * Check whether Vote is vaild !
     *
     * @param $answers
     * @param $vote
     * @return $this|bool|void
     */
    public function voteVerify($answers, $vote)  // Notice: Depend on Model Object and Collection Object !
    {
        $range = $vote->questions->options->id;
        if (empty($answers->diff($range))) {
            $verifyQuestions = $answers->map(function ($answer, $key) {
                return $answer->question->id;
            });
            $unique = $verifyQuestions->unique();
            $required = collect($vote->questions->where('optional', 0)->id);
            if (empty($required->diff($unique))) {
                $vote->questions->each(function ($question, $key) use ($verifyQuestions) {
                    if ($verifyQuestions->search($question->id) != $question->range || $question->type == 'string') abort(500); // illegal answers :( # of option of specific question is not match
                });
                // @TODO Have Not Yet Limited Chooing the Same Option Several time in One Question :(
                return true;
            }
            return redirect()->back()->withInput()->withErrors('Missing Requried field'); // Required field has to be filled !
        }
        return abort(500); // illegal answer :( Out of Range: Choosing options that are not in this vote.
    }


}
