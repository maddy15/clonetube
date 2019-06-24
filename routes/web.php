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

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/webhook/encoding','EncodingWebhookController@handle');

Route::get('videos/{video}','VideoController@show');

Route::post('videos/{video}/views','VideoViewController@create');

Route::get('search','SearchController@index');

Route::get('/videos/{video}/votes','VideoVoteController@show');


Route::get('/videos/{video}/comments','VideoCommentController@index');

Route::get('/subscription/{channel}','ChannelSubscriptionController@show');

Route::get('/channel/{channel}','ChannelController@show');

Route::group(['middleware' => ['auth']], function() {
    //uploads
    Route::get('upload','VideoUploadController@index')->name('upload');
    Route::post('upload','VideoUploadController@store');

    //videos
    Route::get('/videos','VideoController@index');
    Route::get('/videos/{video}/edit','VideoController@edit');
    Route::post('/videos','VideoController@store');
    Route::put('/videos/{video}','VideoController@update');
    Route::delete('/videos/{video}','VideoController@destroy');

    //channel
    Route::get('/channel/{channel}/edit','ChannelSettingsController@edit');
    Route::put('/channel/{channel}/edit','ChannelSettingsController@update');

    //votes
    Route::post('/videos/{video}/votes','VideoVoteController@create');
    Route::delete('/videos/{video}/votes','VideoVoteController@remove');

    //comments
    Route::post('/videos/{video}/comments','VideoCommentController@create');
    Route::delete('/videos/{video}/comments/{comment}','VideoCommentController@destroy');

    //subscribe
    Route::post('/subscription/{channel}','ChannelSubscriptionController@create');
    Route::delete('/subscription/{channel}','ChannelSubscriptionController@destroy');
});
