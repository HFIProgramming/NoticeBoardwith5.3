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
Route::get('/logout', 'Auth\LoginController@logout'); // maybe not a good idea :(
// 认证结束

// @TODO 国际日结束之后主页改回HomeController
//Route::get('/', 'HomeController@index');
Route::get('/', function () {
	return redirect('/about');
});

Route::get('/about', function () {
	return view('about');
});
// @TODO 关于我们界面

Route::get('/intl/{ticket}', function ($ticket) {
	return redirect('/vote/ticket/' . $ticket);
});

// ** 访客区域 **
// 以下页面部分需要验证，但是需要做方法过滤，请注意保护！

// Vote 区域
Route::group(['prefix' => 'vote'], function () {

	Route::group(['middleware' => 'vote_group'], function () {
		// 访客 Ticket 验证
		Route::get('/ticket/{ticket}', 'VoteController@showVoteGroup')->where(['ticket' => '[a-z0-9]+']);
		// 访客 Ticket 认证结束
	});

	Route::group(['middleware' => 'vote_result'], function () {
		// 投票结果处理
		Route::get('/id/{id}/ticket/{ticket}/result', 'VoteController@showVoteResult')->where(['id' => '[0-9]+', 'ticket' => '[a-z0-9]+']);
		// 投票结果结束
	});

	Route::group(['middleware' => 'vote'], function () {
		// 投票处理认证
		Route::get('/id/{id}/ticket/{ticket}', 'VoteController@showIndividualVote')->where(['id' => '[0-9]+', 'ticket' => '[a-z0-9]+']);
		Route::post('/id/{id}/ticket/{ticket}', 'VoteController@voteHandler')->where(['id' => '[0-9]+', 'ticket' => '[a-z0-9]+']);
		// 投票处理结束
	});

});

// ** 登录区域 **
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
		Route::get('/vote/group/{id}', 'VoteController@showVoteGroup')->where(['id' => '[0-9]+']);
		Route::group(['middleware' => 'vote'], function () {
			// 投票处理认证
			Route::get('/id/{id}/', 'VoteController@showIndividualVote')->where(['id' => '[0-9]+']);
			Route::post('/id/{id}/', 'VoteController@voteHandler')->where(['id' => '[0-9]+']);
			// 投票处理结束
		});
		Route::group(['middleware' => 'vote_result'], function () {
			// 投票结果处理
			Route::get('/id/{id}/result', 'VoteController@showVoteResult')->where(['id' => '[0-9]+']);
			// 投票结果结束
		});

		// @TODO Login 尚未完成

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
	Route::group(['prefix' => 'vote'], function () {
		//票据区域
		Route::get('/ticket', 'Admin\VoteController@viewTickets');
		Route::post('/ticket', 'Admin\VoteController@generateTickets');
		//票据结束
		
		//Ticket状态管理
		Route::get('/ticket/status','Admin\VoteController@checkStatus');
		Route::post('/ticket/status','Admin\VoteController@searchTicket');
		Route::get('/ticket/toggle/{id}','Admin\VoteController@toggleTicketStatus');
		Route::get('/ticket/activate/{noneOrAll}','Admin\VoteController@toggleAllTickets');
		Route::get('/ticket/clearallvote/{id}','Admin\VoteController@clearVoteRecord');
		Route::post('/ticket/toggle/with/range','Admin\VoteController@toggleTicketStatusWithRange');
	});

});

// 错误信息
Route::get('/error/custom', function () {
	return response()->view('errors.custom');
});

