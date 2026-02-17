<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use App\Models\UserGame;
use App\Enums\GameStatus;
use Illuminate\Http\Request;

class UserGameController extends Controller
{
    /**
     * Agregar un juego a la biblioteca del usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => ['required', 'exists:games,id'],
            'platform_id' => ['required', 'exists:platforms,id'],
            'status' => ['required', 'in:' . implode(',', GameStatus::values())],
        ]);

        // Verificar que no exista ya
        $exists = UserGame::where('user_id', $request->user()->id)
            ->where('game_id', $validated['game_id'])
            ->where('platform_id', $validated['platform_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya tienes este juego en tu biblioteca');
        }

        // Crear entrada
        UserGame::create([
            'user_id' => $request->user()->id,
            'game_id' => $validated['game_id'],
            'platform_id' => $validated['platform_id'],
            'status' => $validated['status'],
            'started_at' => now(),
        ]);

        return back()->with('success', 'Juego agregado a tu biblioteca');
    }

    /**
     * Cambiar estado de un juego
     */
    public function updateStatus(Request $request, UserGame $userGame)
    {
        // Verificar que el juego pertenece al usuario
        $this->authorize('update', $userGame);

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', GameStatus::values())],
        ]);

        // Actualizar estado
        $userGame->update([
            'status' => GameStatus::from($validated['status']),
            'completed_at' => $validated['status'] === 'completed' ? now() : $userGame->completed_at,
        ]);

        return back()->with('success', 'Estado actualizado correctamente');
    }

    /**
     * Actualizar notas personales
     */
    public function updateNotes(Request $request, UserGame $userGame)
    {
        $this->authorize('update', $userGame);

        $validated = $request->validate([
            'personal_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $userGame->update($validated);

        return back()->with('success', 'Notas guardadas correctamente');
    }

    /**
     * Actualizar tiempo jugado manualmente
     */
    public function updatePlaytime(Request $request, UserGame $userGame)
    {
        $this->authorize('update', $userGame);

        $validated = $request->validate([
            'played_minutes' => ['required', 'integer', 'min:0'],
        ]);

        $userGame->update($validated);

        return back()->with('success', 'Tiempo de juego actualizado');
    }

    /**
     * Eliminar juego de la biblioteca (soft delete)
     */
    public function destroy(UserGame $userGame)
    {
        $this->authorize('delete', $userGame);

        $userGame->delete();

        return back()->with('success', 'Juego eliminado de tu biblioteca');
    }

    /**
     * Restaurar juego eliminado
     */
    public function restore($id)
    {
        $userGame = UserGame::onlyTrashed()->findOrFail($id);
        
        $this->authorize('restore', $userGame);

        $userGame->restore();

        return back()->with('success', 'Juego restaurado');
    }
}