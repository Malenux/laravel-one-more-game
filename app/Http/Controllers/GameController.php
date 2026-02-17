<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use App\Models\UserGame;
use App\Enums\GameStatus;
use App\Jobs\SyncSteamLibrary;
use Illuminate\Http\Request;

class GameController extends Controller
{
    
     * Mostrar biblioteca del usuario
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Obtener filtros
        $status = $request->input('status');
        $platformId = $request->input('platform');
        $search = $request->input('search');
        
        // Query base
        $query = $user->userGames()
            ->with(['game', 'platform'])
            ->whereNull('deleted_at');
        
        // Aplicar filtros
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($platformId) {
            $query->where('platform_id', $platformId);
        }
        
        if ($search) {
            $query->whereHas('game', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        // Paginar resultados
        $userGames = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Obtener estadísticas
        $stats = $user->getStats();
        
        // Obtener plataformas para el filtro
        $platforms = Platform::orderBy('name')->get();
        
        return view('games.index', compact('userGames', 'stats', 'platforms'));
    }

    /**
     * Sincronizar juegos desde Steam
     */
    public function syncSteam(Request $request)
    {
        $user = $request->user();
        
        // Verificar que tenga Steam vinculado
        if (!$user->hasSteamLinked()) {
            return back()->with('error', 'No tienes Steam vinculado. Vincula tu cuenta primero.');
        }
        
        // Despachar Job en background
        SyncSteamLibrary::dispatch($user);
        
        return back()->with('success', 'Sincronizando juegos en segundo plano. Esto puede tardar unos minutos...');
    }

    /**
     * Mostrar detalles de un juego
     */
    public function show(Game $game, Request $request)
    {
        $user = $request->user();
        
        // Obtener la entrada del usuario para este juego
        $userGames = UserGame::where('user_id', $user->id)
            ->where('game_id', $game->id)
            ->with('platform')
            ->get();
        
        // Obtener logros del juego
        $achievements = $game->achievements()->with('platform')->get();
        
        // Logros desbloqueados por el usuario
        $unlockedAchievements = $user->achievements()
            ->where('game_id', $game->id)
            ->pluck('achievement_id')
            ->toArray();
        
        return view('games.show', compact('game', 'userGames', 'achievements', 'unlockedAchievements'));
    }

    /**
     * Buscar juegos (para autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $games = $request->user()
            ->games()
            ->where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'cover_url']);
        
        return response()->json($games);
    }
}