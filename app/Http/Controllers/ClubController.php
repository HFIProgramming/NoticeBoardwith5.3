<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\User;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
	//
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['showIndividualClub']]);
		$this->user = Auth::user();
	}

	public function showIndividualClub($id)
	{
		$club = Club::Id($id);
		// @Todo permission check
			return view('club.individual')->withClub($club);
	}

	public function creatClubApplication(Request $request)
	{
		//@Todo permission check
		if ($club = Club::Id($request->id)) {
			if (Comment::create([
				'user_id'  => $this->user->id,
				'club_id'  => $request['id'],
			])
			) {
				if ($club->save()) {
					return redirect()->back()->withMessage('成功');
				}
				abort(500); // Something wrong with the club :(
			}

			return redirect()->back()->withInput()->withErrors('申请提交失败!');
		}
		abort(500); // club does not exist :(

	}

	protected function checkPemission($club)
	{
		switch ($club->is_public) {
			case 1:
				return true;
				break;
			case 0:
				if (Auth::check()) {
					$roles = explode("|", $club->is_hidden);
					if (!in_array($this->user->role, $roles)) {
						$grades = explode("|", $club->level_limitation);
						if (!in_array($this->user->grade, $grades)) {
							return true;
						}
						abort(403, trans('auth.role_limitation'));
					}

					return false;
					break;
				}

				return false;
		}
	}

}
