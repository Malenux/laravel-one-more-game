<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\MongoDB\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private Game $game) {}

    public function index()
    {
        try {
            $games = $this->game->all();

            return View::make('public.home')
                ->with('games', $games);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
