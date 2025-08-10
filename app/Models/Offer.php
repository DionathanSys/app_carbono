<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enum\StatusOfferEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    protected $casts = [
        'value' => MoneyCast::class,
        'status' => StatusOfferEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }
}
