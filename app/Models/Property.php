<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $table = 'properties';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
