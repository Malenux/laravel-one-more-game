<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    protected $table = 'platforms';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_platform')
                    ->withPivot('external_game_id')
                    ->withTimestamps();
    }

    public function externalAccounts(): HasMany
    {
        return $this->hasMany(ExternalAccount::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }
}