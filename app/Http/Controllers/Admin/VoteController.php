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
	 * @TODO rewrite
	 * @param Request $request
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function generateTickets(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'prefix'  => 'nullable|string',
			'length'  => 'required|numeric',
			'vote_group_id' => 'required|numeric',
			'number'  => 'required|numeric',
		]);
		if ($validator->fails()){
			return redirect()->back()->withErrors($validator)->withInput();  // When Validator fails, return errors
		}
		for ($i = 1; $i <= $request->number; $i++) {
			$ticket_string = randomString($request->length, $request->prefix);
			$vote_group_id = $request->vote_group_id;
			if(count(Ticket::where('string',$ticket_string)->get()) == 0){ //prevent duplicated ticket strings
				Ticket::create([
					'string' => $ticket_string,
					'vote_group_id' => $vote_group_id
				]);
			}
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

		uasort($results, function ($question1, $question2) {
		    return ($question1['count'] > $question2['count']) ? -1 : 1;
        });

		return view('vote.result')->withResults($results)->withVote($vote);
	}


	/**
	 * show tickets for admin
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function checkStatus(){
		$ticket = Ticket::get();
		return view('vote/ticketstatus')->withTicket($ticket);
	}

	/**
	 * search tickets for admin
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function searchTicket(Request $request){
		$id = $request->ticketid;
		$ticket = Ticket::where('id',$id)->get();
		return view('vote/ticketstatus')->withTicket($ticket);
	}

	/**
	 * activate or de-activate ticket.
	 * @param $id : Int
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function toggleTicketStatus(Request $request){
		$id = $request->id;
		$currentTicketStatus = Ticket::find($id)->active;
		Ticket::where('id',$id)->update([
			'active' => ($currentTicketStatus) ? 0 : 1
			]);
		return redirect('/admin/vote/ticket/status');
	}



	/**
	 * activate or de-activate ticket.
	 * @param $startIndex : Int
	 * @param $endIndex : Int
	 * @param $action : String
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function toggleTicketStatusWithRange(Request $request){
		$startIndex = $request->startIndex;
		$endIndex = $request->endIndex;
		$action = $request->action;
		for($id = $startIndex; $id <= $endIndex; $id++){
			if (!empty($ticket = Ticket::find($id))){
				$ticket->update([
					'active' => ($action == "activate") ? 1 : 0
				]);
			}
		}
		return redirect('/admin/vote/ticket/status');
	}

	/**
	 * activate or disable all tickets.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function toggleAllTickets(Request $request){
		$action = $request->noneOrAll;
		switch ($action) {
			case 'all':
				Ticket::where('active','0')->update([
					'active' => '1'
				]);
				break;
			case 'none':
				Ticket::where('active','1')->update([
					'active' => '0'
				]);
				break;

			default:break;
		}
		return redirect('/admin/vote/ticket/status');
	}

	/**
	 * clear vote record for given ticket id.
	 * @param $id:Int
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function clearVoteRecord(Request $request){
		$id = $request->id;
		$data = Ticket::find($id)->clearVoteRecord();
		return redirect('/admin/vote/ticket/status');
	}
}
