<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\MongoDB\Game;
use App\Models\MongoDB\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private Game $game, private Faq $faq) {}

public function index()
{
    try {
        $games = $this->game->all();

        $faqs = $this->faq
            ->where('name', 'HOME')
            ->get()
            ->filter(fn($faq) => $faq->active === true);

        return View::make('public.home')
            ->with('games', $games)
            ->with('faqs', $faqs);
    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage(),
        ], 500);
    }
}
}