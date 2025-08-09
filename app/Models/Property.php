<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Property extends Model
{
    protected $table = 'properties';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instruments(): HasMany
    {
        return $this->hasMany(Instrument::class);
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
