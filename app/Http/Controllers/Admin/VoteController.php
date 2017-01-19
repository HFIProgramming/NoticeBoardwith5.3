<?php

namespace App\Http\Controllers\Admin;

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
