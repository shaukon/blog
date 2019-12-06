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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
//    Route::get('admin/en', 'Admin\LoginController@encrypt');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::resource('category', 'CategoryController');
    Route::resource('cate/changeorder', 'CategoryController@changeOrder');

    Route::resource('links', 'LinksController');
    Route::resource('links/changeorder', 'LinksController@changeOrder');

    Route::resource('navs', 'NavsController');
    Route::resource('navs/changeorder', 'NavsController@changeOrder');

    Route::resource('article', 'ArticleController');

    Route::any('upload', 'CommonController@upload');
});