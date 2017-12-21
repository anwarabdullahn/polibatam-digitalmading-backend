<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
      $this->setDefaultPublicAsset();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      if(!Storage::disk('local')->exists('public/banner/images')){
        Storage::makeDirectory('public/banner/images');
      }
      if (!Storage::disk('local')->exists('public/announcement/images')) {
        Storage::makeDirectory('public/announcement/images');
      }
      if (!Storage::disk('local')->exists('public/event/images')) {
        Storage::makeDirectory('public/event/images');
      }
      if (!Storage::disk('local')->exists('public/uploads/avatars')) {
        Storage::makeDirectory('public/uploads/avatars');
      }
    }

    public function setDefaultPublicAsset() {
      $avatarDefault = Storage::disk('resources')->get('assets/defaults/avatar.jpg');
      Storage::disk('local')->put('/public/uploads/avatars/avatar.jpg', $avatarDefault);
    }
}
