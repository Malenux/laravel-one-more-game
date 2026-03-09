<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GameRequest;
use App\Models\Game;
use App\Services\SitemapService;

class GameController extends Controller
{
  
  public function __construct(private Game $game, private SitemapService $sitemapService){}
  
  public function index()
  {
    try{

      $games = $this->game
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables.games', ['records' => $games])->render(),
          'form' => view('components.forms.games', ['record' => $this->game])->render()
        ], 200); 

      }else{

        $view = View::make('admin.games.index')
        ->with('records', $games)
        ->with('record', $this->game);

        return $view;
      }
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function create()
  {
    try {
      if (request()->ajax()) {
        return response()->json([
          'form' => view('components.forms.games', ['record' => $this->game])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function store(GameRequest $request)
  {            
    try{

      $data = $request->validated();

      $game = $this->game->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $this->sitemapService->updateOrCreateSlug('games', $game->id, $game->name);

      $games = $this->game
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/message.update');
      }else{
        $message = \Lang::get('admin/message.create');
      }
      
      return response()->json([
        'table' => view('components.tables.games', ['records' => $games])->render(),
        'form' => view('components.forms.games', ['record' => $this->game])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(Game $game)
  {
    try{
      return response()->json([
        'form' => view('components.forms.games', ['record' => $game])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function destroy(Game $game)
  {
    try{
      $game->delete();

      $this->sitemapService->deleteSlug('games', $game->id);

      $games = $this->game
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/message.destroy');
      
      return response()->json([
        'table' => view('components.tables.games', ['records' => $games])->render(),
        'form' => view('components.forms.games', ['record' => $this->game])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }
}
