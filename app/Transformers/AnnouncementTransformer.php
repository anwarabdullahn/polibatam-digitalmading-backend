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
      'file'         => url('file/'.$announcement->file),
      'category'     => $announcement->category->name,
      'created_at'     => $announcement->created_at,
      'author'       => [
        'name'  => $announcement->user->name,
        'avatar' => url('profile/'.$announcement->user->avatar),
      ]
    ];
  }
}
