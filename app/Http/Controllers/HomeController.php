<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the completion form if user is not active
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCompletionForm(Request $request)
    {
        if ($request->user()->active == 0) {
            return view('user.completion'); // User is not active.
        } else {
            return redirect('/'); // User is active already.
        }
    }

    /**
     * Get a validator for an incoming completion request.
     *
     * @param array $data
     * @return mixed
     */
    protected function validatorCompletion(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255', 'regex:/([A-Za-z])/', 'unique:users'],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'english_name' => ['required', 'max:255', 'regex:/([A-Za-z])/'],
            'phone_number' => ['nullable', 'numeric', 'regex:^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\\d{8}$', 'unique:users'],
            'wechat' => 'nullable|string|unique:users'
        ]);
    }

    /**
     * Complete user info
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function completeUserInfo(Request $request)
    {
        $user = $request->user(); // Get user first :)
        if ($user && $user->active != 1) {
            if ($errors = $this->validatorCompletion($data = $request->all())->validate()) {
                return redirect()->back()->withErrors($errors)->withInput();  // When Validator fails, return errors
            }
            // Looks good!
            if ($user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'english_name' => $data['english_name'],
                'phone_number' => $data['phone_number'],
                'wechat' => $data['wechat'],
                'active' => '1'
            ])
            ) return redirect('/notice'); // Success! turn to notice
            abort(500); // Fails to save info, abort with 500
        }
        return redirect('/login');  // Fail to get user, turn to login page
    }
}
