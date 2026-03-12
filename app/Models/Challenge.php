<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'word',
        'category',
        'difficulty',
    ];

    public function gameSessions()
    {
        return $this->hasMany(GameSession::class);
    }
}