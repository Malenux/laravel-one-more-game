<?php

namespace App\Enums;

enum GameStatus: string
{
    case PLAYING = 'playing';
    case PENDING = 'pending';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PLAYING => 'Jugando',
            self::PENDING => 'Pendiente',
            self::COMPLETED => 'Completado',
        };
    }

    public function color(): string
    {
        return match($this) {
			self::PENDING => 'gray',
			self::PLAYING => 'blue',
			self::COMPLETED => 'green',
        };
    }
}