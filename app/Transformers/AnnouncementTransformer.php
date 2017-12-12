<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Announcement;

class AnnouncementTransformer extends TransformerAbstract
{
     public function transform($announcements)
     {
       $allAnnouncement = collect();
       foreach ($announcements as $announcement) {
         $t = collect([
           'title'        => $announcement->title,
           'image'        => $announcement->image,
           'description'  => $announcement->description,
           'user'        => $announcement->user->name,
           'category'     => $announcement->category->name
         ]);
         $allAnnouncement->push($t);
       }
       // dd($allAnnouncement);
       return [
         'announcements'=>$allAnnouncement,
       ];
     }
}
