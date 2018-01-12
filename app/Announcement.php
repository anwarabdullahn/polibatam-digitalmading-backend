<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
      'title' , 'description' , 'image' , 'id_user' , 'id_category','status','file'
    ];

    protected $hidden = [

    ];

    public function getStatusAttribute($value)
    {
      if ($value == 0) {
        return 'Hide';
      }
      return 'Show';
    }

    public function user() {
      return $this->hasOne('App\User', 'id', 'id_user');
    }

    public function category() {
      return $this->hasOne('App\AnnouncementCategories', 'id', 'id_category');
    }

    public function setTitleAttribute($value) {
      $this->attributes['title'] = ucwords($value);
    }

}
