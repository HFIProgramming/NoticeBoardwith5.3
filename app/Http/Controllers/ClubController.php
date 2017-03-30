<?php

namespace App\Http\Controllers;

use App\ClubUser;
use Illuminate\Http\Request;
use App\Club;
use App\User;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
	//
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'showIndividualClub']]);
		$this->user = Auth::user();
	}

	public function index()
	{
		return view('club.index')->withClub(Club::All());
	}

	public function showIndividualClub($id)
	{
		$club = Club::Id($id);
		if ($this->checkPermission($club)) {

			return view('club.individual')->withClub($club);

		}
	}

	public function createUserApplication(Request $request)
	{

		$clubId = $request->id;
		if ($club = Club::Id($clubId)) {
			if ($club = $this->user->clubs()->find($clubId)) {

				if ($club->pivot->status == 'rejected') {
					$club->pivot->status = 'pending';
					return redirect()->back()->withMessage('成功');
				}
				return redirect()->back()->withInput()->withErrors('您不能提交申请!');

			} else {
				ClubUser::create([
					'user_id' => $this->user->id,
					'club_id' => $request['id'],
				]);
				return redirect()->back()->withMessage('成功');
			}

			/*
			if ($clubUser = ClubUser::where([['user_id', $this->user->id], ['club_id', $request->id]])->firstOrFail()) {
				$clubUser->role = 'pending';
			} else {
				ClubUser::create([
					'user_id' => $this->user->id,
					'club_id' => $request['id'],
				]);
			}
			*/

			return redirect()->back()->withInput()->withErrors('申请提交失败!');


		}

		abort(500);

	}

	//@TODO CLUB MASTER APPLICATION VERIFY


	protected function checkPermission($club)
	{
		switch ($club->is_public) {
			case 1:
				return true;
				break;
			case 0:
				if (Auth::check()) {
					if (ExplodeExist($club->is_hidden, $this->user->role))
						if (ExplodeExist($club->level_limitation, $this->user->grade)) {
							return true;
						}
				}
				break;
		}

		abort(403, __('auth.role_limitation'));
	}


}
