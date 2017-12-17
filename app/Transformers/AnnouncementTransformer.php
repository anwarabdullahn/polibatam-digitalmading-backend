<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Announcement;

class AnnouncementTransformer extends TransformerAbstract
{
     public function transform($announcements)
     {
       $author = collect();
       foreach ($announcements as $announcement) {
         $u = collect([
           'name'  => $announcement->user->name,
           'avatar' => $announcement->user->avatar,
         ]);
         $author->push($u);
        //  $author = array (
        //   'name'  => $announcement->user->name,
        //   'avatar' => $announcement->user->avatar,
        // );
       }

       $allAnnouncement = collect();
       foreach ($announcements as $announcement) {
         $t = collect([
           'title'        => $announcement->title,
           'image'        => $announcement->image,
           'description'  => $announcement->description,
           'category'     => $announcement->category->name,
           'author'       => $author,
         ]);
         $allAnnouncement->push($t);
       }
       // dd($allAnnouncement);
       return [
         'announcements'=>$allAnnouncement,
       ];
     }
}
