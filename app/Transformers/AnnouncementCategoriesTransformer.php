<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Announcement;
use App\AnnouncementCategories;

class AnnouncementCategoriesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
     public function transform(AnnouncementCategories $category)
     {
       $categoriesCount = Announcement::where('id_category',$category->id)
                                      ->where('status', '1')
                                      ->count();

       return [
         'id'           => $category->id,
         'name'        => $category->name,
         'image'        => url('images/'.$category->image),
         'amount'       =>$categoriesCount,

       ];
     }
}
