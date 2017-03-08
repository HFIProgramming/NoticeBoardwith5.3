<?php

namespace App\Http\Controllers;

use App\Answer;

use App\Events\UpdateModelIPAddress;
use Illuminate\Http\Response;
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
	 * show vote group
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function showVoteGroup(Request $request)
	{
		$ticket = Ticket::ticket($request->ticket);
		return view('vote.landing')->withTicket($ticket);
	}

	/**
	 * show vote pages
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showIndividualVote(Request $request)
	{
		$id = $request->id;
		return view('vote.individual')->withVote(Vote::Id($id)); //Else show vote page
	}


	/**
	 * Vote handler :)
	 *
	 * @TODO String type Answer still Need Further Step
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function voteHandler(Request $request)
	{
		// init
		$voteId = $request->id;
		$ticket = Ticket::ticket($request->ticket);
		$answers = collect(json_decode($request->selected));  // turn string to int
		$vote = Vote::Id($request->id);
		$result = $this->verifyAnswers($answers, $vote);

		if ($result === true) {  // Safety First :)
			switch ($request->type) {  // Start Dash!
				case 'ticket':
					foreach ($answers as $answer) {
						$modelAns = new Answer;
						$modelAns->option_id = $answer;
						$modelAns->source_id = $ticket->id;
						$modelAns->source_type = 'ticket';
					}
					event(new UpdateModelIPAddress('ticket', $ticket->id, 'vote.ticket', $request->ip()));
					$modelAns->saveOrFail();
					return redirect('/vote/id/' . $voteId . '/ticket/' . $ticket->string . '/result/');
					break;
				case 'user':
					$userId = $request->user()->id;
					foreach ($answers as $answer) {
						$modelAns = new Answer;
						$modelAns->option_id = $answer;
						$modelAns->source_id = $ticket->id;
						$modelAns->source_type = 'user';
					}
					$modelAns->saveOrFail();
					return redirect('/vote/id/' . $voteId . '/result/');
					break;
			}
		} else {
			return redirect('/error/custom')->withErrors(['warning' => Lang::get('vote.checksum_fail')]);
		}
	}

	/**
	 * Show Vote Result :)
	 *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showVoteResult(request $request)
	{
		$voteId = $request->id;
		return view('vote.result')->withVote(Vote::Id($voteId));
	}


	/* Check whether Vote is valid !
	*
	* @param $answers
	* @param $vote
	* @return bool
	*/
	private function verifyAnswers($answers, $vote)  // Notice: Depend on Model Object and Collection Object !
	{
		$this->checkIfRepeatingOptions($answers);
		$this->checkIfAllFilled($answers, $vote);
		$this->checkIfOptionsFilledMatch($answers, $vote);
		return true;
	}

	/**
	 * @param $answers
	 */
	private function checkIfRepeatingOptions($answers)
	{
		if ($answers->diff($answers->unique())->isEmpty()) {
			return;
		}
		abort(500);
	}

	/**
	 * @param $answers
	 * @param $vote
	 */
	private function checkIfAllFilled($answers, $vote)
	{
		$filled = $answers->map(function ($answer) {
			return Option::Id($answer)->question->id;
		})->unique();// Get all filled questions
		$required = collect($vote->questions->where('optional', 0)->map(function ($question) {
			return $question->id;
		}));
		if ($required->diff($filled)->isEmpty()) {
			return;
		}
		return redirect()->back()->withInput()->withErrors('Missing Required field', $required->diff($filled)); // @TODO diff return
	}

	/**
	 * @param $answers
	 * @param $vote
	 */

	private function checkIfOptionsFilledMatch($answers, $vote)
	{
		$optionsFilled = array_count_values($answers->map(function ($answer) {
			return Option::Id($answer)->question->id;
		})->flatten()->toArray());
		$vote->questions->each(function ($question) use ($optionsFilled) {
			if ($optionsFilled[$question->id] != $question->range) {
				abort(500);
			} // illegal answers :( # of options for a specific question is not match
		});

		return;
	}
}
