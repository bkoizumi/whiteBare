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

// line用Callback
Route::get('line/callback',  'WebhookController@Webhook');
Route::post('line/callback',  'WebhookController@Webhook');
Route::get('img/{type}/{message}/{img_height}/{img_width}', 'ImageController@showImg')->where([ 'type', '[A-Za-z]+', 'img_height', '[0-9]+', 'img_width', '[0-9]+']);
// Route::get('event_join/{eventID}/{type}', 'EventJoinController@index')->where(['eventID', '[0-9]+' ,  'type', '[A-Za-z]+']);

// Lineログインからメンバー表示
Route::get('line/showMember',  'LineLoginController@showMember');

Auth::routes();
Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => 'auth'], function(){

        Route::get('/',  'HomeController@index');
        Route::get('home',  'HomeController@index');
        Route::get('dashboard',  'DashboardController@index');
        Route::get('friends',  'FriendsController@index');
        Route::post('friends/resist',  'FriendsController@resist');

        //管理者管理
        Route::get('admin', 'AdminController@index');
        Route::get('admin/create', 'AdminController@create');
        Route::get('admin/edit/{uid}', 'AdminController@edit')->where(['uid', '[0-9]+']);
        Route::post('admin/resist', 'AdminController@resist');

        // 配信リスト
        Route::get('target', 'TargetController@index');
        Route::get('target/create', 'TargetController@create');
        Route::get('target/edit/{uid}', 'TargetController@edit')->where(['id', '[0-9]+']);
        Route::post('target/resist', 'TargetController@resist');

        // メッセージ
        Route::get('message', 'MessageController@index');
        Route::get('message/create', 'MessageController@create');
        Route::get('message/edit/{uid}', 'MessageController@edit')->where(['id', '[0-9]+']);
        Route::post('message/resist', 'MessageController@resist');
        Route::post('message/receive/send', 'MessageController@send');
        Route::get('message/receive/{lid}', 'MessageController@receiveMegDetail');
        Route::get('message/receive', 'MessageController@receive');

        // 自動応答
        Route::get('keywords', 'KeywordsController@index');
        Route::get('keywords/create', 'KeywordsController@create');
        Route::get('keywords/edit/{uid}', 'KeywordsController@edit')->where(['id', '[0-9]+']);
        Route::post('keywords/resist', 'KeywordsController@resist');

        // イベント
        Route::get('event', 'EventController@index');
        Route::get('event/create', 'EventController@create');
        Route::get('event/edit/{uid}', 'EventController@edit')->where(['id', '[0-9]+']);
        Route::post('event/resist', 'EventController@resist');

    });
