<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($events)
      {
        $author = collect();
        foreach ($events as $event) {
          $u = collect([
            'name'  => $event->user->name,
            'avatar' => $event->user->avatar,
          ]);
          $author->push($u);
         //  $author = array (
         //   'name'  => $announcement->user->name,
         //   'avatar' => $announcement->user->avatar,
         // );
        }

        $allEvent = collect();
        foreach ($events as $event) {
          $t = collect([
            'title'         => $event->title,
            'date'          => $event->date,
            'image'         => $event->image,
            'description'   => $event->description,
            'author'        => $author,
          ]);
          $allEvent->push($t);
        }
        // dd($allAnnouncement);
        return [
          'events'=>$allEvent,
        ];
      }
}
