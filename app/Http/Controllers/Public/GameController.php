<?php

namespace App\Http\Controllers\Public;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\MongoDB\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(private Game $game) {}

    public function show(Request $request)
    {
        try {
           $game = $this->game->where('_id', $request->attributes->get('sitemap')->entity_id )->first();

            $view = View::make('public.game')->with('game', $game);

            return $view;
        } catch (\Exception $e) {
            return View::make('public.error');
        }
    }
}