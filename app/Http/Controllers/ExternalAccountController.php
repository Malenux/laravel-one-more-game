<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\ExternalAccount;
use App\Services\SteamService;
use Illuminate\Http\Request;

class ExternalAccountController extends Controller
{
    /**
     * Mostrar cuentas vinculadas
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $externalAccounts = $user->externalAccounts()->with('platform')->get();
        $platforms = Platform::orderBy('name')->get();
        
        return view('external-accounts.index', compact('externalAccounts', 'platforms'));
    }

    /**
     * Vincular cuenta de Steam (manual)
     */
    public function storeSteam(Request $request)
    {
        $validated = $request->validate([
            'steam_id' => ['required', 'string', 'size:17'],
        ]);

        // Validar SteamID
        if (!SteamService::isValidSteamId($validated['steam_id'])) {
            return back()->with('error', 'SteamID inválido. Debe ser un SteamID64 de 17 dígitos.');
        }

        $user = $request->user();
        $steam = Platform::where('slug', 'steam')->firstOrFail();

        // Verificar si ya existe
        $exists = ExternalAccount::where('user_id', $user->id)
            ->where('platform_id', $steam->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya tienes Steam vinculado');
        }

        // Crear cuenta externa
        ExternalAccount::create([
            'user_id' => $user->id,
            'platform_id' => $steam->id,
            'external_user_id' => $validated['steam_id'],
        ]);

        return back()->with('success', 'Steam vinculado correctamente. Ahora puedes sincronizar tus juegos.');
    }

    /**
     * Desvincular cuenta
     */
    public function destroy(ExternalAccount $externalAccount)
    {
        $this->authorize('delete', $externalAccount);

        $platformName = $externalAccount->platform->name;
        $externalAccount->delete();

        return back()->with('success', "{$platformName} desvinculado correctamente");
    }
}