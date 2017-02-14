<?php

namespace App\Http\Controllers;

use App\Answer;
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
	 *
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
		return view('vote.individual')->withVote(Vote::Id($request->id))->withUrl($request->url());
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
		$answers = collect(array_map('intval', explode(',', $request->answer)));  // turn string to int
		$vote = Vote::Id($request->id);
		$id = 0; // set default
		$result = $this->verifyAnswers($answers, $vote);
		if ($result === true) {  // Safety First :)
			switch ($request->type) {  // Start Dash!
				case 'ticket':
					$answers->each(function ($answer) {
						Answer::create([
							'option_id' => $answer,
							'user_id'   => 0
							// 'content' => empty($answer->content) ? $answer->content : NULL,
						]);
					});
					$ticket = Ticket::ticket($request->ticket)->first();
					$ticket->is_used = 1;  // Mark as used
					if (!$ticket->save()) {
						abort(500); // Something goes wrong :(
					}
					break;
				case 'user':
					$answers->each(function ($answer) use ($request) {
						Answer::create([
							'option_id' => $answer,
							'user_id'   => $request->user()->id,
							// 'content' => empty($answer->content) ? $answer->content : NULL,
						]);
					});
					$id = $request->user()->id;
					break;
			}
			$vote = $vote->first();
			if ($vote->save()) {
				return view('vote.success');
			}
			abort(500);  // Something goes wrong :(
		} else {
			return $result;
		}
	}


	/**
	 * Check whether Vote is valid !
	 *
	 * @param $answers
	 * @param $vote
	 * @return $this|bool|void
	 */
	private function verifyAnswers($answers, $vote)  // Notice: Depend on Model Object and Collection Object !
	{
		$range = $vote->questions->map(function ($question, $key) {
			return $question->options->map(function ($option, $key) {
				return $option->id;
			});
		})->flatten();// Get available options range
		if ($answers->diff($answers->unique())->isEmpty()) {
			if ($answers->diff($range)->isEmpty()) {
				$verifyQuestions = $answers->map(function ($answer, $key) {
					return Option::Id($answer)->question->id;
				});// Get all filled questions
				$unique = $verifyQuestions->unique();
				$required = collect($vote->questions->where('optional', 0)->map(function ($question, $key) {
					return $question->id;
				}));
				if ($required->diff($unique)->isEmpty()) {
					$verifyQuestions = array_count_values($verifyQuestions->flatten()->toArray()); // counting elements...
					$vote->questions->each(function ($question, $key) use ($verifyQuestions) {
						if ($verifyQuestions[$question->id] != $question->range
							//|| $question->type == 'string'
						) abort(500); // illegal answers :( # of options for a specific question is not match
					});

					return true;
				}

				return redirect()->back()->withInput()->withErrors('Missing Requried field', $required->diff($unique)); // Required field has to be filled !
			}

			return abort(500); // illegal answer :( Out of Range: Choosing options that are not in this vote.
		}

		return abort(500); // Answers repeating options
	}

}
