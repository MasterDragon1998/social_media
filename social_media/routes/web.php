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

Route::get('/', 'PagesController@index');

Route::resource('/posts', 'PostsController');

Route::resource('/votes', 'VotesController', ['only' => ['index']]);
Route::post('/votes/store/{post_id}', 'VotesController@store');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
