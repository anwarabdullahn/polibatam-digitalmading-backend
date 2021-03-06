<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use Notifiable;

    protected $table = 'mahasiswas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim','name', 'email', 'password','verification_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','remember_token'
    ];

    public function getNameAttribute($value)
    {
      return ucwords($value);
    }

    public function setNameAttribute($value) {
      $this->attributes['name'] = ucwords($value);
    }

    public function getVerifiedAttribute($value)
    {
      if ($value == 'true') {
        return 'Activated';
      }
      return 'NotActivated';
    }
}
