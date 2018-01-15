<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
  Route::prefix('mhs')->group(function (){
    
    Route::prefix('auth')->group(function(){
      Route::post('register' , 'AuthAPI@register');
      Route::post('login' , 'AuthAPI@login');
      Route::get('verify/{token}' , 'AuthAPI@verify')->name('verify');
    });

    Route::get('banner' , 'BannerController@getAPI');

    Route::prefix('announcement')->group(function(){
      Route::get('' , 'AnnouncementController@getAPI');
      Route::get('category' , 'AnnouncementCategoriesController@getAPI');
      Route::get('category/{id}' , 'AnnouncementController@byCategoryAPI');
    });

    Route::prefix('event')->group(function(){
      Route::get('' , 'EventController@getAPI');
    });

  });
});
