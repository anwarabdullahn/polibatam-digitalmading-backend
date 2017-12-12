<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
// use App\Banner;

class BannerTransformer extends TransformerAbstract
{
     public function transform($banners)
     {
       $allBanner = collect();
       foreach ($banners as $banner) {
         $t = collect([
           'title' => $banner->title,
           'image' => $banner->image,
         ]);
         $allBanner->push($t);
       }

       return [
         'banners'=>$allBanner,
       ];
         // return [
         //       'title'       => $banner->title,
         //       'status'      => $banner->status,
         //       'image'       => $banner->image,
         //       'registered'  => $banner->created_at->diffForhumans(),
         // ];
     }
}
