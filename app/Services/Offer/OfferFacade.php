<?php

namespace App\Services\Offer;

use App\Models;

class OfferFacade
{
    public static function create(Models\Instrument $instrument, array $data)
    {
        $createAction = new Actions\Create();
        return $createAction->handle([
            'instrument_id' => $instrument->id,
            'amount'        => $data['amount'],
            'value'         => $data['value'],
        ]);
    }
}
