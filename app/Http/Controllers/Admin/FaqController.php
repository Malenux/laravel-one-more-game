<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\MongoDB\Faq;
use App\Services\SitemapService;

class FaqController extends Controller
{
  
  public function __construct(private Faq $faq, private SitemapService $sitemapService){}
  
  public function index()
  {
    try{

      $faqs = $this->faq
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
          'form' => view('components.forms.faqs', ['record' => $this->faq])->render()
        ], 200); 

      }else{

        $view = View::make('admin.faqs.index')
        ->with('records', $faqs)
        ->with('record', $this->faq);

        return $view;
      }
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function create()
  {
    try {
      if (request()->ajax()) {
        return response()->json([
          'form' => view('components.forms.faqs', ['record' => $this->faq])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function store(FaqRequest $request)
{            
    try{
        $data = $request->validated();
        $data['_id'] = $request->input('id');
        $data['active'] = $request->boolean('active');

        $faq = $this->faq->updateOrCreate([
          '_id' => $request->input('id')
        ], $data);

      $faqs = $this->faq
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/message.update');
      }else{
        $message = \Lang::get('admin/message.create');
      }
      
      return response()->json([
        'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
        'form' => view('components.forms.faqs', ['record' => $this->faq])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(Faq $faq)
  {
    try{
      return response()->json([
        'form' => view('components.forms.faqs', ['record' => $faq])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function destroy(Faq $faq)
  {
    try{
      $faq->delete();

      $faqs = $this->faq
      ->when(request('name'), fn($q) => $q->where('name', 'like', '%' . request('name') . '%'))
      ->when(request('question'), fn($q) => $q->where('question', 'like', '%' . request('question') . '%'))
      ->when(request('answer'), fn($q) => $q->where('answer', 'like', '%' . request('answer') . '%'))
      ->when(request('created_at'), fn($q) => $q->whereDate('created_at', request('created_at')))
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/message.destroy');
      
      return response()->json([
        'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
        'form' => view('components.forms.faqs', ['record' => $this->faq])->render(),
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
