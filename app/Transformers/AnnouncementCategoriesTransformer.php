<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class AnnouncementCategoriesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
     public function transform($categories)
     {
       $allCategory = collect();
       foreach ($categories as $category) {
         $t = collect([
           'id'           => $category->id,
           'name'        => $category->name
         ]);
         $allCategory->push($t);
       }
       return [
         'categories'=>$allCategory,
       ];
     }
}
