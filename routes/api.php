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

// Public APIs
// @TODO Improve naming and stuffs?
Route::get('/post/for/{numberPerPage?}', 'API\PostController@getPosts');
Route::get('/post/id/{id}','API\PostController@loadIndividualPost');

// Storage APIs
Route::get('/storage/token/{token}/echo/filename/{filename}', 'API\FileController@handleEcho');

