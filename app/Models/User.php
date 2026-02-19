<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withTimestamps();
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'user_games')
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

    public function userGames(): HasMany
    {
        return $this->hasMany(UserGame::class);
    }

    public function externalAccounts(): HasMany
    {
        return $this->hasMany(ExternalAccount::class);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
                    ->withPivot('unlocked_at')
                    ->withTimestamps();
    }

    public function steamAccount(): ?ExternalAccount
    {
        return $this->externalAccounts()
                    ->whereHas('platform', fn($query) => $query->where('slug', 'steam'))
                    ->first();
    }

    public function hasSteamLinked(): bool
    {
        return !is_null($this->steamAccount());
    }

    public function getStats(): array
    {
        $userGames = $this->userGames()->get();

        return [
            'total_games' => $userGames->count(),
            'playing_count' => $userGames->where('status', \App\Enums\GameStatus::PLAYING)->count(),
            'pending_count' => $userGames->where('status', \App\Enums\GameStatus::PENDING)->count(),
            'completed_count' => $userGames->where('status', \App\Enums\GameStatus::COMPLETED)->count(),
            'total_minutes' => $userGames->sum('played_minutes'),
            'total_hours' => round($userGames->sum('played_minutes') / 60, 1),
            'achievements_unlocked' => $this->achievements()->count(),
        ];
    }
}
