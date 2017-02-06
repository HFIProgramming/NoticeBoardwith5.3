<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Post;
use App\Comment;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'showIndividualPost']);
        $this->user = Auth::user();
    }

    /**
     * Show post for specific post id
     *
     * @param $id
     * @return $this
     */
    public function showIndividualPost($id)
    {
        if ($post = Post::Id($id)->first()) {
            switch ($post->is_public) {
                case 1:
                    return view('post.individual')->withPost(Post::with('hasManyComments')->find($id));
                    // eager load cannot throw 404 exception :(
                    break;
                case 0:
                    if (Auth::check()) {
                        $roles = explode("|", $post->is_hidden);
                        if (!in_array($this->user->role, $roles)) {
                            $grades = explode("|", $post->level_limitation);
                            if (!in_array($this->user->grade, $grades)) {
                                return view('post.individual')->withPost(Post::with('hasManyComments')->find($id));
                            }
                            return redirect('/403')->withErrors(['warning' => Lang::get('auth.level_limitation')]);
                        }
                        return redirect('/403')->withErrors(['warning' => Lang::get('auth.role_limitation')]);
                    }
                    return Redirect::guest(route('login'))
                        ->withErrors(['warning' => Lang::get('login.login_required', [
                            'process' => 'Post Viewing'
                        ]),]);
                    break;
            }
        }
        return redirect('/404')->withErrors(['warning' => Lang::get('post.post_no_found')]); // Vote No Found
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
        if ($post = Post::Id($request->id)->first()) {
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
