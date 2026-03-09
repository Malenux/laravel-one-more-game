<?php

namespace App\Http\Controllers\Public;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Services\SitemapService;

class GameController extends Controller
{
    public function __construct(private Game $game, private SitemapService $sitemapService) {}

    public function index()
    {
        try {
            $games = $this->game->all();

            return View::make('public.games')->with('games', $games);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $sitemap = $this->sitemapService->getSlug($request->game);
           
            $game = $this->game->where('id', $sitemap->entity_id)->first();

            return view('public.game', compact('game'));
        } catch (\Exception $e) {
            return View::make('public.error');
        }
    }
}