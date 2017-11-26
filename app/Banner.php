<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','image', 'email','status','id_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function getStatusAttribute($value)
    {
      if ($value == 0) {
        return 'Hide';
      }
      return 'Show';
    }

    public function setTitleAttribute($value) {
      $this->attributes['title'] = ucwords($value);
    }

    public function getTitleAttribute($value) {
      return ucwords($value);
    }

    public function scopeActive($query, $isActive)
    {
        return $query->where('status', $isActive);
    }

    public function user() {
      return $this->hasOne('App\User', 'id', 'id_user');
    }
}
