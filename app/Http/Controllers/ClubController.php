<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\User;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
	//
	protected $user;

	public function __construct()
	{
		$this->middleware('auth', ['except' => ['index', 'showIndividualClub']]);
	}


	public function index()
	{
		return Club::all();
		return view('club.index')->withClub(Club::All());
	}

	public function showIndividualClub($id)
	{
		$club = Club::Id($id);
		if ($this->checkPermission($club)){
			return Response()->json($club);
			return view('club.individual')->withClub($club);
		} else {
			return redirect('/login')->withErrors(['warning' => __('login.login_required', [
				'process' => 'Club Viewing'
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


	public function showApplication(Request $request)
	{
		$clubId = $request->id;
		if ($this->checkRole($clubId,'charger')) {
		   return view('club.application')->withClub(Club::Id($clubId)->users->wherePivot('status', 'pending')->withPivot)->firstOrFail();
		} else {
			abort(403, __('auth.role_limitation'));
		}
	}


	public function replyApplication(Request $request)
	{
		$clubId = $request->id;
		if ($this->checkRole($clubId,'charger')) {
			//@TODO
		} else {
			abort(403, __('auth.role_limitation'));
		}
	}

	public function showClubMember($id)
	{
		if ($this->checkRole($id,'member')) {
			return Club::Id($id)->users('status','approved')->get(); //->pivot->where('status', 'approved')->withPivot()->firstOrFail();
		} else {
			abort(403, __('auth.role_limitation'));
		}
	}


	public function checkPermission($club)

	{
		switch ($club->is_public) {
			case 1:
				return true;
				break;
			case 0:
				if (Auth::check()) {
					if (!ExplodeExist($club->is_hidden, $this->user->role))
						if (!ExplodeExist($club->level_limitation, $this->user->grade)) {
							return true;
						}
					abort(403, __('auth.role_limitation'));
				}
				break;
		}
		return false;
	}

	public function checkRole($clubId,$role)
	{
		$userRole = Auth::user()->clubs()->findOrFail($clubId)->pivot->role;
		switch ($role){
			case 'master':
				if ($userRole === 'master'){
					return true;
				}else{
					return false;
				}
				break;

			case 'charger':
				if (($userRole === 'master')||($userRole === 'charger')){
					return true;
				}else{
					return false;
				}
				break;

			case 'member':
				if ($userRole !== 'applicant'){
					return true;
				}else{
					return false;
				}
				break;

			default:
				abort(500, __('error.500'));;
		}

	}

}
