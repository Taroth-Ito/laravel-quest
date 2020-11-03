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

Route::get('/', 'UsersController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログインフォームを表示
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//ログインフォームに入力された内容（メールアドレス・パスワードなどを）を送信
Route::post('login', 'Auth\LoginController@login')->name('login.post');
//ログアウトを行う
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//省略した書き方
Route::resource('users', 'UsersController', ['only' => ['show']]);

//フォローする・外す

Route::group(['prefix' => 'users/{id}'], function () {
    Route::get('followings', 'UsersController@followings')->name('followings');
    Route::get('followers', 'UsersController@followers')->name('followers');
    });

//他社サービスとの連携
Route::resource('rest','RestappController', ['only' => ['index', 'show', 'create', 'store', 'destroy']]);   
    
Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('unfollow');
});
    
Route::group(['middleware' => 'auth'], function () {
    Route::put('users', 'UsersController@rename')->name('rename');
});    

Route::group(['middleware' => 'auth'], function () {
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']]);
});


//チャンネル・ユーザ名を変更する
Route::group(['middleware' => 'auth'], function () {
    Route::put('users', 'UsersController@rename')->name('rename');
    
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('unfollow');
    });
    
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']]);
});


