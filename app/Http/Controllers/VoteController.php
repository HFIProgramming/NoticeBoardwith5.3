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
use Illuminate\Support\Facades\Lang;


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
	 * @TODO 研究一下预加载
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
		$answers = collect(json_decode($request->selected));
		$vote = Vote::Id($request->id);
		$voteIsValid = false;
		// @TODO 简化流程 将结果转为数字后处理，因为一开始进入的数据是字符串 diff功能不生效
		if($this->checkIfRepeatingOptions($answers) == false){ //如果没有重复的元素
			if($this->checkIfAllFilled($answers, $vote)){ //并且所有的选项填完了
				if($this->checkIfOptionsFilledMatch($answers,$vote)){
					$voteIsValid = true;
				}
			}
			else{
				return redirect()->back()->withErrors(['warning' => Lang::get('vote.option_left_not_filled')]);
			}
		}

		if ($voteIsValid === true) {  // Safety First :)
			switch ($request->type) {  // Start Dash!
				case 'ticket':
					foreach ($answers as $answer) {
						$modelAns = new Answer;
						$modelAns->option_id = $answer;
						$modelAns->source_id = $ticket->id;
						$modelAns->source_type = 'ticket';
						$modelAns->saveOrFail();
					}
					event(new UpdateModelIPAddress('ticket', $ticket->id, 'vote.ticket', $request->ip()));

					return redirect('/vote/id/' . $voteId . '/ticket/' . $ticket->string . '/result/');
					break;
				case 'user':
					$userId = $request->user()->id;
					foreach ($answers as $answer) {
						$modelAns = new Answer;
						$modelAns->option_id = $answer;
						$modelAns->source_id = $userId;
						$modelAns->source_type = 'user';
						$modelAns->saveOrFail();
					}

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

	/**
	 * @param $answers
	 */
	private function checkIfRepeatingOptions($answers)
	{
		$answers = $answers->toArray();
		$origin = $answers;
		$answers = array_unique($answers);
		if (count($origin) == count($answers)){ //答案中没有重复： If two arrays have the same number of values, this means that there is no repetition within answers.
			return false;
		}
		else{ //答案中有重复: 如果两个数组的有不同数量的元素，说明array_unique()函数压缩了一些元素，也就是证明答案中有重复。
			return true;
		}
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
			return true;
		}
		return false;
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
				return false;
			} // illegal answers :( # of options for a specific question is not match
		});
		return true;
	}
}
