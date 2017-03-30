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
		}else{
			return redirect('/login')->withErrors(['warning' => __('login.login_required', [
				'process' => 'Viewing Club'
			]),]);
		}
	}


	public function createUserApplication(Request $request)
	{

		$clubId = $request->id;
		if ($club = Club::Id($clubId)) {
			if ($club = $this->user->clubs()->findOrFail($clubId)) {

				switch ($club->pivot->status) {
					case 'rejected':
						$club->pivot->status = 'pending';
						$club->saveOrFail();
						return redirect()->back()->withMessage(__('club.apply_success'));
						break;
					case 'approved':
						return redirect()->back()->withMessage(__('club.duplicate_approved_apply'));
						break;
					case 'blacklisted':
						return redirect()->back()->withMessage(__('club.blacklisted'));
						break;
					case 'pending':
						return redirect()->back()->withMessage(__('club.duplicate_pending_apply'));
						break;
					default:
						abort(500, __('error.500'));
				}
			} else {
				$club->users()->attach($this->user->id, ['status' => 'pending']);
				return redirect()->back()->withMessage(__('club.apply_success'));
			}

		}

		abort(500, __('error.500'));

	}

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
				return false;
				break;
		}

		abort(403, __('auth.role_limitation'));
	}

}
