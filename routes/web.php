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

Route::get('/announcement', 'AnnouncementController@index')->name('announcement');
Route::get('/announcement/images/{id}', 'AnnouncementController@getImage');
Route::post('/announcement', 'AnnouncementController@create');
Route::post('/announcement/delete', 'AnnouncementController@delete');
Route::post('/announcement/update', 'AnnouncementController@update');
