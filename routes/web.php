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
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('tasks','TaskController')->middleware('auth');

Route::get('tasks/status/{id}', 'TaskController@update_status')->name('update_status');

Route::resource('meetings','MeetingController')->middleware('auth');

Route::resource('details','DetailController')->middleware('auth');

Route::get('add_users', 'DetailController@add_users')->name('add_users');

Route::get('meetings/show_users', 'MeetingController@show_users')->name('show_users');

Route::get('meetings/connect_between/{user_id}/{meeting_id}', 'MeetingController@connect_between')->name('connect_between');


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

