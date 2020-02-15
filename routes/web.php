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

Auth::routes();
Route::get('threads/create', 'ThreadsController@create');
Route::get('/threads',"ThreadsController@index");
Route::post('/threads',"ThreadsController@store");
//Route::resource('threads',"ThreadsController");
Route::get('/threads/{channel}/{thread}',"ThreadsController@show");
Route::get('threads/{channel}', 'ThreadsController@index');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post( '/threads/{channel}/{thread}/replies',"RepliesController@store");
Route::get( '/threads/{channel}/{thread}/replies',"RepliesController@index");

Route::post( '/threads/{channel}/{thread}/subscriptions',"ThreadSubscriptionController@store")->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');


Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::post('/replies/{reply}/favorites', 'FavouriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavouriteController@destroy');

Route::get('/home', 'HomeController@index')->name('home');
