<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
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
       return [
         'id'           => $category->id,
         'name'        => $category->name
       ];
     }
}
