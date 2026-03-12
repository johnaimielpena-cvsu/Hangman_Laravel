<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GameSession extends Model
{
    protected $fillable = [
        'user_id',
        'challenge_id',
        'player_name',
        'category',
        'answer',
        'mistakes',
        'score',
        'status',
        'is_inactive',
    ];

    protected $casts = [
        'is_inactive' => 'boolean',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_inactive', false);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_inactive', true);
    }

    // Helpers
    public function markInactive(): void
    {
        $this->update(['is_inactive' => true]);
    }

    public function isInactive(): bool
    {
        return $this->is_inactive;
    }
}
