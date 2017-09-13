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

    $latestThreads = \App\Thread::orderBy('updated_at', 'desc')->take(15)->get();

    return view('welcome', ['latestThreads' => $latestThreads]);
});


//Route::resource('/threads', 'ThreadController');
Route::post('/threads', 'ThreadController@store');
Route::get('/diskussion', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');

Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');

Route::post('/replies/{reply}/favorite', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorite', 'FavoriteController@destroy');

Route::delete('/notifications/{notification}', 'UsersNotificationsController@destroy');
Route::get('/notifications', 'UsersNotificationsController@index');


Route::get('/pages/create', 'PageController@create')->name('pages.create')->middleware('admin');
Route::post('/pages', 'PageController@store')->name('pages.store')->middleware('admin');

Route::resource('/workout', 'WorkoutController');
Route::get('/my-position', 'ProfileController@getMyPosition');
Route::post('/my-position', 'ProfileController@myPosition');

Auth::routes();
Route::get('/oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('oauth_login');
Route::get('/oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/oauth/{driver}/deauthorize', 'Auth\LoginController@handleProviderDeauthorize');

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/api/upload/avatar', 'UserAvatarController@store')->name('upload_avatar');

Route::get('/profile/{user}', 'ProfileController@show')->name('profile');
Route::get('/kanal/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}', function($channel) {
    return redirect('/kanal/' . $channel);
});
Route::get('/{channel}/{thread}', 'ThreadController@show')->name('thread');
Route::delete('{channel}/{thread}', 'ThreadController@destroy');
Route::post('/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::get('{channel}/{thread}/replies', 'ReplyController@index');
Route::post('{channel}/{thread}/replies', 'ReplyController@store')->name('reply_to_thead');
Route::get('/{page}', 'PageController@show');
