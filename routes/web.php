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

//認証系のルーティングを追加
Auth::routes();
//Google用
Route::prefix('login')->name('login.')->group(function(){
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
});
//Googleログイン時のユーザー登録
Route::prefix('register')->name('register.')->group(function(){
    Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
    Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');
});
//topページ
Route::get('/', 'ArticleController@index')->name('articles.index');
//indexのルーティングを削除
//authミドルウェアでログイン済かチェック
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
Route::resource('/articles', 'ArticleController')->only(['show']);

//ユーザーページ表示
Route::prefix('users')->name('users.')->group(function(){
    Route::get('/{name}', 'UserController@show')->name('show');
    //プロフィール編集画面
    Route::get('/{name}/edit', 'UserController@edit')->name('edit');
    //プロフィール編集処理
    Route::patch('/{name}/update', 'UserController@update')->name('update');
    //パスワード編集画面
    Route::get('/{name}/password/edit', 'UserController@editPassword')->name('password.edit');
    //パスワード編集処理
    Route::patch('/{name}/password/update', 'UserController@updatePassword')->name('password.update');
});

//いいね機能
Route::prefix('articles')->name('articles.')->group(function() {
    Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
    Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});
