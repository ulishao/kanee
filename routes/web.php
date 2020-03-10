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
Route::group(['prefix' => 'h5'], function () {
    Route::get('home', 'H5\HomeController@index');
});
Route::get('/', function () {
    return "";

});
Route::get('user/info', 'UserController@info');
Route::get ('/dd' , 'UserController@dd');
Route::get('/img', 'ImgController@index');
Route::get( '/url' , 'ImgController@url' );
Route::get( '/sui' , 'ImgController@sui' );
Route::get('/sui1', 'ImgController@sui1');
Route::get( '/img_id' , 'ImgController@show' );
Route::get( '/user/code' , 'UserController@code' );
Route::get('/user/code_ka', 'UserController@code_ka');
Route::get ('/user/qing_code' , 'UserController@qing_code');
Route::post( '/user' , 'UserController@create' );
Route::get ('/user/show', 'UserController@show');
Route::get('/title', 'UserController@title');
Route::get('/user/show1', 'UserController@show1');
Route::post ('/user/update', 'UserController@update');
Route::post('/user/ditu', 'UserController@ditu');
Route::get('/user/get_index', 'UserController@getIndex');
Route::post('/user/form', 'UserController@form');
Route::post ('/image', 'ImageController@store');
Route::post ('/content', 'ContentController@store');
Route::get ('/bizhi', 'ImgController@bizhi');
Route::get ('/biget' , 'ImgController@biget');
Route::get ('/kan', 'ContentController@kan');
Route::get('/get', 'ImgController@redis');
Route::get ('/content/show', 'ContentController@show');
Route::get ('/content', 'ContentController@index');
Route::post ('/content/comment', 'ContentController@create');
Route::get ( 'menus' , 'MenuController@index' );
Route::get ('user', 'UserController@index');
Route::get('user/send', 'UserController@send');
Route::get ('img/list', 'ImgController@list');
Route::get('img/user', 'ImgController@user');
Route::post( 'user/collect' , 'UserController@collect' );
Route::post ('user/like', 'UserController@like');
Route::get ('user/getlike', 'UserController@getlike');
Route::get('user/getlike1', 'UserController@getlike1');
Route::post('user/is_like', 'UserController@is_like');
Route::get('home', 'HomeController@index');

/**
 * 卡片
 */
Route::post('ka/create', 'UserController@ka');

/**
 * tag
 */
Route::get('user/tag', 'UserController@tag');
Route::get('user/h', 'UserController@h');
Route::get('user/code_qq', 'UserController@code_qq');