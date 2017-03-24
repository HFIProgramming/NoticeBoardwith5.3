<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Sample test case
Route::get('now', function () {
	return date("Y-m-d H:i:s");
});
Route::post('echo', function (Request $request) {
	return $request->all();
});

// 登录相关
Route::post('/username', 'Auth\LoginController@verifyUsername');
Route::get('now', function () {
	return date("Y-m-d H:i:s");
});


// Sample API
// This is a sample with bad name, just for test.
// Change them as long as it works
// @TODO
Route::get('/post/page/{page?}/{numberPerPage?}', 'HomeController@encodeHome');
Route::get('/user/id/{id}', 'UserController@encodeUser');
Route::get('/post/id/{id}', 'PostController@encodePost');