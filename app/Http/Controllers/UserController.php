<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
	//This controller closely related with user profile

	/**
	 * UserController constructor.
	 */
	public function __construct()
	{

	}

	public function encodeUser(Request $request)
	{
		return response()->json(User::where('id', $request->id)->firstorFail());
	}

}
