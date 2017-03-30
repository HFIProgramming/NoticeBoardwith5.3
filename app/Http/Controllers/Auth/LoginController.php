<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;


class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';  // Default turn to noticeboard

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Override login credentials.
	 *
	 * @param Request $request
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$request->merge([$field = usernameIdentifier($request->username) => $request->username]);

		return $request->only($field, 'password');
	}

	/**
	 * Override name string
	 *
	 * @return string
	 */
	public function username()
	{
		return 'username';
	}


    /**
     * Method override to send correct error messages for login
     * @param  Request $request 
     * @return Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {

        if ( ! User::where(usernameIdentifier($request->username), $request->username)->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'no_user' => Lang::get('auth.no_user'),
                ]);
        }

        if ( ! User::where(usernameIdentifier($request->username), $request->username)->where('password', bcrypt($request->password))->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'password' => Lang::get('auth.password'),
                ]);
        }

    }

	/**
	 * API to check user's condition before login.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function verifyUsername(Request $request)
	{
		if (!empty($user = User::username($field = usernameIdentifier($request->username), $request->username)->first())) {
			$result['status'] = 1;
			$result['active'] = $user->active; // Username found, return status.
		} else {
			$result['status'] = 0; // Username no found.
		}
		$result['field'] = $field;
		$result['username'] = $request->username;

		return response()->json($result);
	}


}
