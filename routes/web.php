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
Route::get( '/img_id' , 'ImgController@show' );
Route::get( '/user/code' , 'UserController@code' );
Route::post( '/user' , 'UserController@create' );
Route::get( '/user' , 'UserController@show' );
Route::post ('/image', 'ImageController@store');