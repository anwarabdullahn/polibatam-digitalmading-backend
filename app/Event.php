<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = [
    'title' , 'description' , 'image' , 'id_user','status'
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

  public function setTitleAttribute($value) {
    $this->attributes['title'] = ucwords($value);
  }
}
