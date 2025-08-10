<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enum\StatusDiversosEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasManyThrough, MorphMany};
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $casts = [
        'value' => MoneyCast::class,
        'status' => StatusDiversosEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function property(): HasManyThrough
    {
        return $this->hasManyThrough(Property::class, Instrument::class);
    }

    /**
     * Relacionamento morph com documentos
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Scope para filtrar propriedades do usuário autenticado
     */
    public function scopeOwner($query, $userId = null)
    {
        $userId = $userId ?: Auth::id();

        if (!$userId) {
            return $query->whereRaw('1 = 0'); // Retorna query vazia se não há usuário
        }

        return $query->where('user_id', $userId);
    }
}
