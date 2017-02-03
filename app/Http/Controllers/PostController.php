<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\Comment;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'showIndividualPost']);
        $this->user = Auth::user();
    }

    /**
     * Show post for specific post id
     * @param $id
     * @return $this
     */
    public function showIndividualPost($id)
    {
        if (!Auth::check() && Post::find($id)->firstOrFail()->is_public == 0) {
            return view('post/show')->withPost(Post::with('hasManyComments', 'tagged')->find($id));
        } // eager load cannot throw 404 exception :(

        return Redirect::guest(route('login'))
            ->withErrors(['warning' => Lang::get('login.login_required', [
                'process' => 'vote'
            ]),]);
    }

    /**
     * Make a reply on a post.
     * @param Request $request
     * @return $this
     */
    public function getReply(Request $request)
    {
        if ($errors = Validator::make($request, [
            'content' => 'required|max:255'
        ])->validate()
        ) {
            return redirect()->back()->withErrors($errors)->withInput();  // When Validator fails, return errors
        }
        if ($post = Post::find($request->id)->first()) {
            if (Comment::create([
                'user_id' => $this->user->id,
                'password' => $request['content'],
                'post_id' => $request['id'],
            ])
            ) {
                $post->last_user = $this->user->id;
                if ($post->save()) {
                    return redirect()->back()->withMessage('成功');
                }
                abort(500); // Something wrong with the post :(
            }
            return redirect()->back()->withInput()->withErrors('评论发表失败!');
        }
        abort(500); // post is not exist :(
    }

    /**
     * Create a new post
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     *
     */
    public function createNewPost(Request $request)
    {
        if ($errors = Validator::make($request, [
            'content' => 'required|max:255',
            'title' => 'required|max:50',
        ])->validate()
        ) {
            return redirect()->back()->withErrors($errors)->withInput();  // When Validator fails, return errors
        }
        if (Post::create([
            'user_id' => $this->user->id,
            'title' => $request['title'],
            'content' => clean($request['content']),
            // @TODO 权限判断
        ])
        ) {
            return redirect()->back()->withMessage('成功');
        }
        abort(500);  // Something goes wrong :(
    }

}
