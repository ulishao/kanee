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

Route::get('/', function () {
    return 'hello git 豫ICP备19015780号-1';

});
Route::get('/img', 'ImgController@index');
Route::get( '/url' , 'ImgController@url' );
Route::get( '/sui' , 'ImgController@sui' );
Route::get('/sui1', 'ImgController@sui1');
Route::get( '/img_id' , 'ImgController@show' );
Route::get( '/user/code' , 'UserController@code' );
Route::post( '/user' , 'UserController@create' );
Route::get ('/user/show', 'UserController@show');
Route::post ('/user/update', 'UserController@update');
Route::post ('/image', 'ImageController@store');
Route::post ('/content', 'ContentController@store');
Route::get ('/bizhi', 'ImgController@bizhi');
Route::get ('/kan', 'ContentController@kan');
Route::get('/get', 'ImgController@redis');
Route::get ('/content/show', 'ContentController@show');
Route::get ('/content', 'ContentController@index');
Route::post ('/content/comment', 'ContentController@create');
Route::get ( 'menus' , 'MenuController@index' );
Route::get ('user', 'UserController@index');
Route::get ('img/list', 'ImgController@list');
Route::post( 'user/collect' , 'UserController@collect' );
Route::post ('user/like', 'UserController@like');
Route::get ('user/getlike', 'UserController@getlike');