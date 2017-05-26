<?php

namespace App\Transformers;

use App\Detail;
use League\Fractal\TransformerAbstract;

class DetailsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Detail $detail
     * @return array
     */
    public function transform(Detail $detail)
    {
        return [
            'quantity' => $detail->quantity,
            'description' => $detail->description,
            'cost' => $detail->unitary_cost
        ];
    }
}
