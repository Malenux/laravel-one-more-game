<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/panel', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::resource('usuarios', 'App\Http\Controllers\Admin\UserController', [
        'parameters' => ['usuarios' => 'user'],
        'names' => [
            'index'   => 'users',
            'create'  => 'users_create',
            'store'   => 'users_store',
            'edit'    => 'users_edit',
            'destroy' => 'users_destroy',
        ]
    ]);
});

Route::group(['prefix' => 'cuenta', 'middleware' => 'auth'], function () {
    Route::get('/perfil', function () {
        return view('customer.dashboard.index');
    })->name('customer-dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/auth-customer.php';
