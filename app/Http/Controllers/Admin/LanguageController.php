<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\ViewModels\Admin\LanguageViewModel as ViewModel;
use Illuminate\Http\Request;
use App\Models\MySQL\Language;
use App\Http\Requests\Admin\LanguageRequest;

class LanguageController extends Controller
{
  public function __construct(private Language $language)
  {
  }
 
  public function index()
  {
    try{
      $filters = ['name' => 'like', 'label' => 'like'];

      $query = $this->language;

      foreach ($filters as $field => $type) {
        $value = request($field);

        if ($value === null || $value === '') {
          continue;
        }

        match ($type) {
          'like' => $query->where($field, 'like', '%' . $value . '%'),
          '='    => $query->where($field, $value),
          default => null,
        };
      }

      $languages = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables', ['tableStructure' => ViewModel::tableStructure(), 'records' => $languages])->render(),
          'form' => view('components.forms', ['formStructure' => ViewModel::formStructure(), 'record' => $this->language])->render()
        ], 200); 

      }else{

        $view = View::make('admin.languages.index')
        ->with('tableStructure', ViewModel::tableStructure())
        ->with('formStructure', ViewModel::formStructure())
        ->with('records', $languages)
        ->with('record', $this->language);

        return $view;
      }
    }catch(\Exception $e){
      return response()->json([
        'message' =>  $e->getMessage(),  
      ], 500);
    }
  }

  public function create()
  {
    try {
      if (request()->ajax()) {
        return response()->json([
          'form' => view('components.forms', ['formStructure' => ViewModel::formStructure(), 'record' => $this->language])->render(),
          
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  $e->getMessage(),
      ], 500);
    }
  }

  public function store(LanguageRequest $request)
  {            
    try{

      $request->validated();
      $data = $request->all();
      $data['_id'] = $request->input('id');

      $language = $this->language->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $languages = $this->language
        ->orderBy('created_at', 'desc')
        ->paginate(10);

      $message = \Lang::get('admin/notification.saved');

      return response()->json([
        'table' => view('components.tables', [
          'tableStructure' => ViewModel::tableStructure(),
          'records' => $languages
        ])->render(),

        'form' => view('components.forms', [
          'formStructure' => ViewModel::formStructure(),
          'record' => $this->language
        ])->render(),

        'message' => $message,
      ], 200);

    }catch(\Exception $e){
      return response()->json([
        'error' => $e->getMessage(),
      ], 422);
    }  
  }

  public function show(Language $language)
  {
    try{
      return response()->json([
        'form' => view('components.forms', ['formStructure' => ViewModel::formStructure(), 'record' => $language])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function destroy(Language $language)
  {
    try{
      $language->delete();

      $languages = $this->language
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/notification.destroy');
      
      return response()->json([
        'table' => view('components.tables', ['tableStructure' => ViewModel::tableStructure(), 'records' => $languages])->render(),
        'form' => view('components.forms', ['formStructure' => ViewModel::formStructure(), 'record' => $this->language])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }
}