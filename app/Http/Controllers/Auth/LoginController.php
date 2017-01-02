<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/home';

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
     * Override login credentials
     *
     * @param Request $request
     * @return array
     */
   protected function credentials(Request $request){
        $field = 'chinese_name';

        if (is_numeric($request->input('name'))) {
        $field = 'phone_number';
        } elseif (filter_var($request->input('name'), FILTER_VALIDATE_EMAIL)) {
        $field = 'email';
    }

        $request->merge([$field => $request->input('name')]);
        return $request->only($field, 'password');
    }

    /**
     * Override name string
     *
     * @return string
     */
    public function username(){
        return 'name';
    }

}
