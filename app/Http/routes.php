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

    Route::get('/', 'Home\IndexController@index');
    Route::get('/cate/{Id}', 'Home\IndexController@cate');
    Route::get('/a/{Id}', 'Home\IndexController@article');


    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');

    Route::get('admin/en', 'Admin\LoginController@encrypt');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::resource('category', 'CategoryController');
    Route::post('cate/changeorder', 'CategoryController@changeOrder');

    Route::resource('links', 'LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder');

    Route::resource('navs', 'NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder');

    Route::resource('article', 'ArticleController');


    Route::post('conf/changeorder', 'ConfigController@changeOrder');
    Route::post('conf/changecontent', 'ConfigController@changeContent');
    Route::get('conf/putfile', 'ConfigController@putFile');
    Route::resource('conf', 'ConfigController');


    Route::any('upload', 'CommonController@upload');
});