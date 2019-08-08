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

Route::get('/home', function () {
    return view('home');
});


Auth::routes();

Route::get('/conversations/showAll/{user}', 'ConversationController@showAll')->name('conversations.showAll');
//Route::post('/conversations', 'ConversationController@store')->name('conversations.store');
//Route::get('/conversations', 'ConversationController@store')->name('conversations.store');
Route::get('/conversations/{conversation}', 'ConversationController@show')->name('conversations.show');
Route::put('/conversations/{conversation}', 'ConversationController@update')->name('conversations.update');

Route::get('/messages/showAll/{conversation}', 'MessageController@showAll')->name('messages.showAll');
Route::post('/messages', 'MessageController@store')->name('messages.store');
Route::get('/messages/{message}', 'MessageController@show')->name('messages.show');
Route::put('/messages/{conversation}', 'MessageController@update')->name('messages.update');

//Route::post('/messages', 'MessageController@store')->name('messages.store');

Route::get('/orders/showAll/{conversation}', 'orderController@showAll')->name('orders.showAll');
Route::post('orders', 'orderController@store')->name('orders.store');
Route::get('/orders/{order}', 'orderController@show')->name('orders.show');
Route::get('/orders/accept/{order}', 'orderController@accept')->name('orders.accept');


Route::get('/profiles/search/{handel}', 'ProfileController@search')->name('profiles.search');
Route::get('/profiles/info/{user}', 'ProfileController@show')->name('profiles.show');
Route::post('/profiles/{user}', 'ProfileController@update')->name('profiles.update');

