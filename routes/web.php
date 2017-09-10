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
    if (auth()->check()) return redirect('home');

    $threads = \App\Thread::latest()->take(15)->get();

    return view('welcome', ['threads' => $threads]);
});
//Route::resource('/threads', 'ThreadController');
Route::post('/threads', 'ThreadController@store');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('thread');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store')->name('reply_to_thead');
Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');

Route::post('/replies/{reply}/favorite', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorite', 'FavoriteController@destroy');

Route::delete('/notifications/{notification}', 'UsersNotificationsController@destroy');
Route::get('/notifications', 'UsersNotificationsController@index');

Route::get('/profile/{user}', 'ProfileController@show')->name('profile');

Route::resource('/workout', 'WorkoutController');
Route::get('/my-position', 'ProfileController@getMyPosition');
Route::post('/my-position', 'ProfileController@myPosition');

Auth::routes();
Route::get('/oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('oauth_login');
Route::get('/oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/oauth/{driver}/deauthorize', 'Auth\LoginController@handleProviderDeauthorize');

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/api/upload/avatar', 'UserAvatarController@store')->name('upload_avatar');