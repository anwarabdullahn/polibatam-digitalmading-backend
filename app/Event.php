<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = [
    'title' , 'description' , 'image' , 'id_user'
  ];

  protected $hidden = [

  ];

  public function user() {
    return $this->hasOne('App\User', 'id', 'id_user');
  }
}
