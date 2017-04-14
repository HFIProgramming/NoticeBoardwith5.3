<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFirstActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;

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
		$posts = Post::with(['comments.user' => function ($query) {
			$query->orderBy('created_at', 'desc');
		}], 'tagged')->orderBy('updated_at', 'desc')->Paginate(15);

		return view('welcome')->withPosts($posts);
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
			return view('user.completion')->withUser($request->user()); // User is not active.
		} else {
			return redirect('/'); // User is active already.
		}
	}

	/**
	 * Complete user info
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function completeUserInfo(UserFirstActive $request)
	{
		$user = $request->user(); // Get user first :)
		$data = $request->all();
		if ($user->update([
			'name'         => $data['name'],
			'email'        => $data['email'],
			'password'     => bcrypt($data['password']),
			'english_name' => $data['english_name'],
			'phone_number' => $data['phone_number'],
			'wechat'       => $data['wechat'],
			'active'       => '1',
			//@TODO 数据库加了表项但是没有添加输入方式
		])
		) return redirect('/notice'); // Success! turn to notice
	}

}
