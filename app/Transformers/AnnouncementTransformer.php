<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Announcement;

class AnnouncementTransformer extends TransformerAbstract
{
     public function transform(Announcement $announcement)
     {
       return [
         'title'        => $announcement->title,
         'image'        => url('/announcement/images/'.$announcement->image),
         'description'  => $announcement->description,
         'category'     => $announcement->category->name,
         'author'       => [
           'name'  => $announcement->user->name,
           'avatar' => url('profile/'.$announcement->user->avatar),
         ]
       ];
     }
}
