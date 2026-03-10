<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;

class UserController extends Controller
{
  
  public function __construct(private User $user){}
  
  public function index()
  {
    try{

      $users = $this->user
      ->when(request('name'),       fn($q) => $q->where('name', 'like', '%' . request('name') . '%'))
      ->when(request('email'),      fn($q) => $q->where('email', 'like', '%' . request('email') . '%'))
      ->when(request('created_at'), fn($q) => $q->whereDate('created_at', request('created_at')))
      ->orderBy('created_at', 'desc')
      ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables.users', ['records' => $users])->render(),
          'form' => view('components.forms.users', ['record' => $this->user])->render()
        ], 200); 

      }else{

        $view = View::make('admin.users.index')
        ->with('records', $users)
        ->with('record', $this->user);

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
          'form' => view('components.forms.users', ['record' => $this->user])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function store(UserRequest $request)
  {            
    try{

      $data = $request->validated();

      unset($data['password_confirmation']);
      
      if (!$request->filled('password') && $request->filled('id')){
        unset($data['password']);
      }
  
      $this->user->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $users = $this->user
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/message.update');
      }else{
        $message = \Lang::get('admin/message.create');
      }
      
      return response()->json([
        'table' => view('components.tables.users', ['records' => $users])->render(),
        'form' => view('components.forms.users', ['record' => $this->user])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(User $user)
  {
    try{
      return response()->json([
        'form' => view('components.forms.users', ['record' => $user])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function destroy(User $user)
  {
    try{
      $user->delete();

      $users = $this->user
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/message.destroy');
      
      return response()->json([
        'table' => view('components.tables.users', ['records' => $users])->render(),
        'form' => view('components.forms.users', ['record' => $this->user])->render(),
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
