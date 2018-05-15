<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $fillable = [
        'pertanyaan1' , 'pertanyaan2' , 'pertanyaan3' , 'pertanyaan4'
    ];
    
    protected $hidden = [

    ];
}
