<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;

class PostController extends Controller
{
	/**
	 * api to load posts as json, alone with author info
	 * @param  $numberPerPage:Int [how many posts should this method return at one time]
	 * @return [JSON]           [The JSON data encoded with post data]
	 */
	public function getPosts(Request $request)
	{
		$post = Post::with('hasManyComments', 'tagged','getAuthor')->orderBy('updated_at', 'desc');
		$numberPerPage = (intval($request->numberPerPage) != 0) ? intval($request->numberPerPage) : null; //This line is to prevent invalid non-numeric string arguments.	
		if (!isset($numberPerPage)) {
			return response()->json($post->paginate($request->numberPerPage));
		}

		return response()->json($post->paginate(10));
	}

}