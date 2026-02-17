<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'name',
        'slug',
        'cover_url',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'game_platform')
                    ->withPivot('external_game_id')
                    ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_games')
                    ->withPivot([
                        'platform_id',
                        'status',
                        'played_minutes',
                        'personal_notes',
                        'started_at',
                        'completed_at',
                        'deleted_at',
                    ])
                    ->withTimestamps();
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }
}