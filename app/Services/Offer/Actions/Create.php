<?php

namespace App\Services\Offer\Actions;

use App\Enum\StatusOfferEnum;
use App\Models;
use App\Traits\UserCheckTrait;
use Illuminate\Support\Facades\Validator;

class Create
{

    use UserCheckTrait;

    protected Models\Offer $offer;

    public function __construct()
    {
        $this->offer = new Models\Offer();
    }

    public function handle(array $data)
    {
        $this->validate($data);

        $this->offer->create([
            'user_id'       => $this->getUserIdChecked(),
            'instrument_id' => $data['instrument_id'],
            'amount'        => $data['amount'],
            'value'         => $data['value'],
            'status'        => StatusOfferEnum::PENDENTE,
        ]);
    }

    private function validate(array $data): void
    {
        Validator::make($data, [
            'instrument_id' => ['required', 'exists:instruments,id'],
            'amount'        => ['required', 'numeric', 'min:0.01'],
            'value'         => ['required', 'numeric', 'min:0.01'],
        ])->validate();
    }
}
