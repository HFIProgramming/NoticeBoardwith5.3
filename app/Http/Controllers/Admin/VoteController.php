<?php

namespace App\Http\Controllers\Admin;

use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Ticket;
use App\Vote;


class VoteController extends Controller
{
	/**
	 * VoteController constructor.
	 */
	public function __construct()
	{
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
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function generateTickets(Request $request)
	{
		if ($errors = Validator::make($request->all(), [
			'prefix'  => 'nullable|string',
			'length'  => 'required|numeric',
			'vote_id' => 'required|numeric',
			'number'  => 'required|numeric',
		])->validate()
		) {
			return redirect()->back()->withErrors($errors)->withInput();  // When Validator fails, return errors
		}
		for ($i = 1; $i <= $request->number; $i++) {
			Ticket::create([
				'string'  => randomString($request->length, $request->prefix),
				'vote_id' => $request->vote_id,
			]);
		}

		return redirect()->back();
	}

	public function showVoteResult(Request $request)
	{
		$vote = Vote::find($request->id);
		$counts = array_count_values($vote->questions->map(function ($question) {
			return $question->options->map(function ($option) {
				return $option->answers->map(function ($answer) {
					return $answer->option_id;  // Escape Numeric
				})->flatten();
			})->flatten();
		})->flatten()->toArray());
		// fallback :(
		$results = [];
		foreach ($counts as $key => $count) {
			$results[$key] = ['questionId' => Option::find($key)->question->id, 'count' => $count];
		}

		return view('vote.result')->withResults($results)->withVote($vote);
	}
}
