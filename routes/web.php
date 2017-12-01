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

Route::group(['middleware' => 'auth'], function(){
  Route::get('/home', 'HomeController@index')->name('home');

  Route::prefix('announcement')->group(function() {
    Route::get('', 'AnnouncementController@index')->name('announcement');
    Route::post('', 'AnnouncementController@create');
    Route::post('/delete', 'AnnouncementController@delete');
    Route::post('/update', 'AnnouncementController@update');
    Route::get('/images/{id}', 'AnnouncementController@getImage');
  });

  Route::prefix('event')->group(function() {
    Route::get('', 'EventController@index')->name('event');
    Route::post('', 'EventController@create');
    Route::post('/update', 'EventController@update');
    Route::post('/delete', 'EventController@delete');
    Route::get('/images/{id}', 'EventController@getImage');
  });

  Route::prefix('ormawa')->group(function() {
    Route::get('', 'UserController@index')->name('ormawa');
    Route::post('', 'UserController@create');
    Route::post('/update', 'UserController@update');
    Route::post('/delete', 'UserController@delete');
    // Route::get('/images/{id}', 'EventController@getImage');
  });

  Route::prefix('banner')->group(function() {
    Route::get('', 'BannerController@index')->name('banner');
    Route::post('', 'BannerController@create');
    Route::post('/update', 'BannerController@update');
    Route::post('/delete', 'BannerController@delete');
    // Route::get('/images/{id}', 'EventController@getImage');
  });
});

Route::get('register', function(){
  return redirect('/page-not-found');
});
