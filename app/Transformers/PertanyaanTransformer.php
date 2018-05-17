<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Pertanyaan;

class PertanyaanTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Pertanyaan $pertanyaan)
    {
        return [
            'pertanyaan1'   => $pertanyaan->pertanyaan1,
            'pertanyaan2'   => $pertanyaan->pertanyaan2,
            'pertanyaan3'   => $pertanyaan->pertanyaan3,
            'pertanyaan4'   => $pertanyaan->pertanyaan4,
        ];
    }
}
