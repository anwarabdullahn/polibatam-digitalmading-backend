<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $fillable = [
        'jawaban1' , 'jawaban2' , 'jawaban3' , 'jawaban4' , 'id_mahasiswa'
    ];

    protected $hidden = [

    ];

    public function mahasiswa() {
        return $this->hasOne('App\Mahasiswa', 'id', 'id_mahasiswa');
    }

    public function getJawaban1Attribute($value)
    {
      if ($value == 1) {
        return 'Sangat Tidak Setuju';
      }else if($value == 2){
        return 'Tidak Setuju';
      }else if($value == 3){
        return 'Ragu - Ragu';
      }else if($value == 4){
        return 'Setuju';
      }
      return 'Sangat Setuju';
    }

    public function getJawaban2Attribute($value)
    {
      if ($value == 1) {
        return 'Sangat Tidak Setuju';
      }else if($value == 2){
        return 'Tidak Setuju';
      }else if($value == 3){
        return 'Ragu - Ragu';
      }else if($value == 4){
        return 'Setuju';
      }
      return 'Sangat Setuju';
    }

    public function getJawaban3Attribute($value)
    {
      if ($value == 1) {
        return 'Sangat Tidak Setuju';
      }else if($value == 2){
        return 'Tidak Setuju';
      }else if($value == 3){
        return 'Ragu - Ragu';
      }else if($value == 4){
        return 'Setuju';
      }
      return 'Sangat Setuju';
    }

    public function getJawaban4Attribute($value)
    {
      if ($value == 1) {
        return 'Sangat Tidak Setuju';
      }else if($value == 2){
        return 'Tidak Setuju';
      }else if($value == 3){
        return 'Ragu - Ragu';
      }else if($value == 4){
        return 'Setuju';
      }
      return 'Sangat Setuju';
    }

}
