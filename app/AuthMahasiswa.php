<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class AuthMahasiswa extends Model
{
  use Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'api_token','id_mahasiswa', 'platfom' ,
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [

    ];

    public function mahasiswa() {
    return $this->hasOne('App\Mahasiswa', 'id', 'id_mahasiswa');
    }
}
