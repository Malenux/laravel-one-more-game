<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlatformRequest;
use App\Models\Platform;
use App\Services\SitemapService;

class PlatformController extends Controller
{
  
  public function __construct(private Platform $platform, private SitemapService $sitemapService){}
  
  public function index()
  {
    try{

      $platforms = $this->platform
        ->when(request('name'),       fn($q) => $q->where('name', 'like', '%' . request('name') . '%'))
        ->when(request('created_at'), fn($q) => $q->whereDate('created_at', request('created_at')))
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables.platforms', ['records' => $platforms])->render(),
          'form' => view('components.forms.platforms', ['record' => $this->platform])->render()
        ], 200); 

      }else{

        $view = View::make('admin.platforms.index')
        ->with('records', $platforms)
        ->with('record', $this->platform);

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
          'form' => view('components.forms.platforms', ['record' => $this->platform])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function store(PlatformRequest $request)
  {            
    try{

      $data = $request->validated();

      $platform = $this->platform->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $this->sitemapService->updateOrCreateSlug('platforms', $platform->id, $platform->name);

      $platforms = $this->platform
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/message.update');
      }else{
        $message = \Lang::get('admin/message.create');
      }
      
      return response()->json([
        'table' => view('components.tables.platforms', ['records' => $platforms])->render(),
        'form' => view('components.forms.platforms', ['record' => $this->platform])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(Platform $platform)
  {
    try{
      return response()->json([
        'form' => view('components.forms.platforms', ['record' => $platform])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function destroy(Platform $platform)
  {
    try{
      $platform->delete();

      $this->sitemapService->deleteSlug('platforms', $platform->id);

      $platforms = $this->platform
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/message.destroy');
      
      return response()->json([
        'table' => view('components.tables.platforms', ['records' => $platforms])->render(),
        'form' => view('components.forms.platforms', ['record' => $this->platform])->render(),
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
