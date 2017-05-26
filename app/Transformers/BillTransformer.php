<?php

namespace App\Transformers;

use App\Bill;
use League\Fractal\TransformerAbstract;

class BillTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'details'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Bill $bill
     * @return array
     */
    public function transform(Bill $bill)
    {
        return [
            'id' => $bill->id,
            'billNumber' => $bill->bill_number,
            'total' => $bill->total,
            'clientName' => $bill->assignment->clientName,
            'clientEmail' => $bill->assignment->clientEmail,
            'date' => $bill->assignment->date,

        ];
    }

    public function includeDetails(Bill $bill)
    {
        return $this->collection( $bill->details, new DetailsTransformer());
    }
}
