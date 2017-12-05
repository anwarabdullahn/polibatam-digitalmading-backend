<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementCategories extends Model
{
  protected $table = 'announcement_categories';
  protected $fillable = [
    'name' 
  ];

  protected $hidden = [

  ];
}
