<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGame extends Model
{
    use SoftDeletes;

    protected $table = 'user_games';

    protected $fillable = [
        'user_id',
        'game_id',
        'platform_id',
        'status',
        'played_minutes',
        'personal_notes',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => GameStatus::class,
        'started_at' => 'date',
        'completed_at' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function scopePlaying($query)
    {
        return $query->where('status', GameStatus::PLAYING);
    }

    public function scopePending($query)
    {
        return $query->where('status', GameStatus::PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', GameStatus::COMPLETED);
    }

    public function getPlayedHoursAttribute(): float
    {
        return round($this->played_minutes / 60, 1);
    }
}