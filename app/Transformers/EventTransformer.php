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
