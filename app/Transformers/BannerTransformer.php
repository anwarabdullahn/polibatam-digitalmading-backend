<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Banner;

class BannerTransformer extends TransformerAbstract
{
     public function transform(Banner $banner)
     {
         return [
               'title'       => $banner->title,
               'image'       => url('/announcement/images/'.$banner->image),
         ];
     }
}
