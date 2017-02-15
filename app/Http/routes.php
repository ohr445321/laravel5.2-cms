<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/**
 * 后台
 */

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){

    //登陆
    Route::get('/login', 'PublicController@login');

    //后台首页
    Route::get('/','IndexController@index');
    
//    Route::group([],function () {
        //后台用户
        Route::resource('/user', 'UserController');
//    });
});