<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
  
  public function __construct(private Customer $customer){}
  
  public function index()
  {
    try{

      $customers = $this->customer
        ->orderBy('created_at', 'desc')
        ->paginate(10);
      
      if(request()->ajax()) {
            
        return response()->json([
          'table' => view('components.tables.customers', ['records' => $customers])->render(),
          'form' => view('components.forms.customers', ['record' => $this->customer])->render()
        ], 200); 

      }else{

        $view = View::make('admin.customers.index')
        ->with('records', $customers)
        ->with('record', $this->customer);

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
          'form' => view('components.forms.customers', ['record' => $this->customer])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
          'message' =>  \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function store(CustomerRequest $request)
  {            
    try{

      $data = $request->validated();

      unset($data['password_confirmation']);
      
      if (!$request->filled('password') && $request->filled('id')){
        unset($data['password']);
      }
  
      $this->customer->updateOrCreate([
        'id' => $request->input('id')
      ], $data);

      $customers = $this->customer
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      if ($request->filled('id')){
        $message = \Lang::get('admin/message.update');
      }else{
        $message = \Lang::get('admin/message.create');
      }
      
      return response()->json([
        'table' => view('components.tables.customers', ['records' => $customers])->render(),
        'form' => view('components.forms.customers', ['record' => $this->customer])->render(),
        'message' => $message,
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(Customer $customer)
  {
    try{
      return response()->json([
        'form' => view('components.forms.customers', ['record' => $customer])->render(),
      ], 200);
    }
    catch(\Exception $e){
      return response()->json([
        'message' => \Lang::get('admin/message.error'),
      ], 500);
    }
  }

  public function destroy(Customer $customer)
  {
    try{
      $customer->delete();

      $customers = $this->customer
      ->orderBy('created_at', 'desc')
      ->paginate(10);

      $message = \Lang::get('admin/message.destroy');
      
      return response()->json([
        'table' => view('components.tables.customers', ['records' => $customers])->render(),
        'form' => view('components.forms.customers', ['record' => $this->customer])->render(),
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
