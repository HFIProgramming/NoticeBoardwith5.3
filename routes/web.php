<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 认证路由
Auth::routes();

// 访客区域
// 以下页面部分需要验证，但是需要做方法过滤，请注意保护！
Route::get('/', function () {
    return view('welcome');
});

Route::get('/vote', 'VoteController@showVotes');
Route::get('/vote/{id}/{ticket}', 'VoteController@showIndividualVote')->where(['id' => '[0-9]+', 'ticket' => '[A-Za-z0-9]+']);
Route::post('/vote/{id}/{ticket}', 'VoteController@voteHandler')->where(['id' => '[0-9]+', 'ticket' => '[A-Za-z0-9]+']);

Route::get('/post/{id}', 'PostController@showIndividualPost')->where(['id' => '[0-9]+']);

// 以下页面都需要登录才能访问
Route::group(['middleware' => 'auth'], function () {

    // 补全信息页
    Route::get('/completion', 'HomeController@showCompletionForm');
    Route::post('/completion', 'HomeController@completeUserInfo');

    // 登录后界面,发现用户登录没有补全信息将会自动跳转补全
    Route::group(['middleware' => 'active'], function () {
        // 登录后主页
        Route::get('/home', 'HomeController@index');

        // 投票相关
        Route::get('/vote/{id}', 'VoteController@showIndividualVote')->where(['id' => '[0-9]+']);
        Route::post('/vote/{id}', 'VoteController@voteHandler')->where(['id' => '[0-9]+']);

        // 帖子相关
        Route::get('/post', function () {
            return view('post/create');
        });
        Route::post('/post/{id}', 'PostController@getReply')->where(['id' => '[0-9]+']);
        Route::post('/post', 'PostController@createNewPost');

    });
});

// 管理员区域
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/vote/ticket', 'Admin\VoteController@viewTickets');
    Route::post('/vote/ticket', 'Admin\VoteController@generateTickets');
    Route::get('/vote/result/{id}', 'Admin\VoteController@showVoteResult')->where(['id' => '[0-9]+']);
});

// 错误信息
Route::get('/404', function () {
    return view('errors.404');
});

