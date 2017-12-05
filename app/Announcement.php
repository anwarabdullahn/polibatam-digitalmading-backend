<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
      'title' , 'description' , 'image' , 'id_user' , 'id_category'
    ];

    protected $hidden = [

    ];

    public function user() {
      return $this->hasOne('App\User', 'id', 'id_user');
    }

    public function category() {
      return $this->hasOne('App\AnnouncementCategories', 'id', 'id_category');
    }
}
