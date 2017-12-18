<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Event;

class EventTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Event $event)
    {
        // $author = collect();
        // foreach ($events as $event) {
        //   $u = collect([
        //     'name'  => $event->user->name,
        //     'avatar' => $event->user->avatar,
        //   ]);
        //   $author->push($u);
        //   break;
        //  //  $author = array (
        //  //   'name'  => $announcement->user->name,
        //  //   'avatar' => $announcement->user->avatar,
        //  // );
        // }
        return [
          'title'         => $event->title,
          'date'          => $event->date,
          'image'        => url('event/images/'.$event->image),
          'description'   => $event->description,
          'author'        => [
            'name'        => $event->user->name,
            'avatar'        => url('profile/'.$event->user->avatar),
          ],
        ];
    }
}
