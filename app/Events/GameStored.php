<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStored
{
  use Dispatchable, SerializesModels;

  public function __construct(
    public $game,
    public $images,
  ) {}
}
