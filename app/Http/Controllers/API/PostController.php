<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
		$post = Post::with('comments', 'tagged','user')->orderBy('updated_at', 'desc');
		$numberPerPage = (intval($request->numberPerPage) != 0) ? intval($request->numberPerPage) : null; //This line is to prevent invalid non-numeric string arguments.	
		if (isset($numberPerPage)) {
			return response()->json($post->paginate($numberPerPage));
		}

		return response()->json($post->paginate(10));
	}

	/**
	 * [Load individual post webpage for public api access]
	 * @param  $id:Int [ID of the post]
	 * @return [view]
	 */
	public function loadIndividualPost(Request $request) {
		$postId = $request->id;
		$post = Post::find($postId);
		if ($this->checkPemission($post)) {
			return view('api.post.individual')->withPost(Post::find($postId));
		} else {
			Redirect::guest(route('login'))
				->withErrors(['warning' => __('login.login_required', [
					'process' => 'Post Viewing',
				]),]);
		}
	}

	/**
	 * Check if the post is public
	 * @param  $post
	 * @return Bool
	 */
	protected function checkPemission($post)
	{
		switch ($post->is_public) {
			case 1:
				return true;
				break;
			case 0:
				if (Auth::check()) {
					$roles = explode("|", $post->is_hidden);
					if (!in_array($this->user->role, $roles)) {
						$grades = explode("|", $post->level_limitation);
						if (!in_array($this->user->grade, $roles)) {
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