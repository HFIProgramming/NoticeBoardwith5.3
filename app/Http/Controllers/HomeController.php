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
     * Get a validator for an incoming completion request.
     *
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'english_name' => 'required|max:255',
            'phone_number' => 'nullable|numeric',
            'wechat' => 'nullable|string'
        ]);
    }

    /**
     * Complete user info
     *
     * @param Request $request
     */
    public function completeUserInfo(Request $request){
        $user = $request->user();
        if ($user && $user->active != 1) {
            $this->validator($data = $request->all())->validate();
            $user->update(
                ['name' => $data['name']],
                ['email' => $data['email']],
                ['password' => bcrypt($data['password'])],
                ['english_name' => $data['english_name']],
                ['phone_number' => $data['phone_number']],
                ['wechat' => $data['wechat']],
                ['active' => '1']
            );
            if ($user->save()){
                redirect('/home');
            }else{
                abort(500);
            }
        }else{
            redirect()->route('login');
        }
    }
}
