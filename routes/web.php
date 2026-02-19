<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () { 
    return view('welcome'); 
});

Route::prefix('admin')->group(function () {
    Route::resource('usuarios', UserController::class, [
        'parameters' => ['usuarios' => 'user'],
        'names' => [
            'index'   => 'users',
            'create'  => 'users_create',
            'store'   => 'users_store',
            'edit'    => 'users_edit',
            'update'  => 'users_update',
            'destroy' => 'users_destroy',
        ]
    ]);
});