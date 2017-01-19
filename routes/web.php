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

// 首页
Route::get('/', function () {
    return view('welcome');
});

// 认证路由
Auth::routes();

// 补全信息页
Route::get('/completion', 'HomeController@showCompletionForm');
Route::post('/completion', 'HomeController@completeUserInfo');

// 访客区域
Route::get('/vote/{id}/{ticket}', 'VoteController@showIndividualVote');
Route::get('/vote/{id}/{ticket}', 'VoteController@voteHandler');

// 登录后界面,发现用户登录没有补全信息将会自动跳转补全
Route::group(['middleware' => 'active'], function(){
    Route::get('/home', 'HomeController@index');
    Route::get('/vote/{id}', 'VoteController@showIndividualVote');
    Route::get('/vote/{id}', 'VoteController@voteHandler');
});

// 管理员区域
Route::group(['middleware' => 'admin'], function(){
    Route::get('/vote/ticket', 'Admin\VoteController@viewTickets');
    Route::post('/vote/ticket', 'Admin\VoteController@generateTickets');
});