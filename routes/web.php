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
Route::get('/completion', function(){
    return view('user.completion');
});
Route::post('/completion', 'UserController@completion');

// 登录后界面,发现用户登录没有补全信息将会自动跳转补全
Route::group(['middleware' => 'active'], function(){
    Route::get('/home', 'HomeController@index');
});
