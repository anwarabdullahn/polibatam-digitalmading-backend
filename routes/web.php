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
    return redirect('/login');
});

Auth::routes();

Route::get('/profile/{id}', 'UserController@getProfile');
Route::get('announcement/images/{id}', 'AnnouncementController@getImage');
Route::get('event/images/{id}', 'EventController@getImage');
Route::get('banner/images/{id}', 'BannerController@getImage');
Route::get('/register/verification/{nim}/{code}', 'MahasiswaController@verification');

Route::group(['middleware' => 'auth'], function(){
  Route::get('/home', 'HomeController@index')->name('home');
  Route::post('/profile', 'UserController@profileUpdate')->name('profile');
  Route::post('/password', 'UserController@passwordUpdate')->name('password');

  Route::prefix('announcement')->group(function() {
    Route::get('', 'AnnouncementController@index')->name('announcement');
    Route::post('', 'AnnouncementController@create');
    Route::post('/delete', 'AnnouncementController@delete');
    Route::post('/update', 'AnnouncementController@update');


    Route::get('/category', 'AnnouncementCategoriesController@index')->name('category');
    Route::post('/category', 'AnnouncementCategoriesController@create');
    Route::post('/category/update', 'AnnouncementCategoriesController@update');
    Route::post('/category/delete', 'AnnouncementCategoriesController@delete');
  });

  Route::prefix('event')->group(function() {
    Route::get('', 'EventController@index')->name('event');
    Route::post('', 'EventController@create');
    Route::post('/update', 'EventController@update');
    Route::post('/delete', 'EventController@delete');

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

  });

  Route::prefix('mahasiswa')->group(function() {
    Route::get('', 'MahasiswaController@index')->name('mahasiswa');
    // Route::post('', 'BannerController@create');
    // Route::post('/update', 'BannerController@update');
    // Route::post('/delete', 'BannerController@delete');

  });
});

Route::get('register', function(){
  return redirect('/page-not-found');
});
