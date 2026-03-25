<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function () {

    
    Route::post('/images', 'App\Http\Controllers\Admin\ImageController@store')->name('images_store');
    Route::get('/images/thumb/{filename}', 'App\Http\Controllers\Admin\ImageController@showThumb')->name('images_thumb');
    Route::delete('/images/{filename}', 'App\Http\Controllers\Admin\ImageController@destroy')->name('images_destroy');
    
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

    Route::resource('clientes', 'App\Http\Controllers\Admin\CustomerController', [
        'parameters' => ['clientes' => 'customer'],
        'names' => [
            'index'   => 'customers',
            'create'  => 'customers_create',
            'store'   => 'customers_store',
            'edit'    => 'customers_edit',
            'destroy' => 'customers_destroy',
        ]
    ]);

    Route::resource('plataformas', 'App\Http\Controllers\Admin\PlatformController', [
        'parameters' => ['plataformas' => 'platform'],
        'names' => [
            'index'   => 'platforms',
            'create'  => 'platforms_create',
            'store'   => 'platforms_store',
            'edit'    => 'platforms_edit',
            'destroy' => 'platforms_destroy',
        ]
    ]);

    Route::resource('juegos', 'App\Http\Controllers\Admin\GameController', [
        'parameters' => ['juegos' => 'game'],
        'names' => [
            'index'   => 'games',
            'create'  => 'games_create',
            'store'   => 'games_store',
            'edit'    => 'games_edit',
            'destroy' => 'games_destroy',
        ]
    ]);

    Route::resource('preguntas', 'App\Http\Controllers\Admin\FaqController', [
        'parameters' => ['preguntas' => 'faq'],
        'names' => [
            'index'   => 'faqs',
            'create'  => 'faqs_create',
            'store'   => 'faqs_store',
            'edit'    => 'faqs_edit',
            'destroy' => 'faqs_destroy',
        ]
    ]);
});

Route::group(['prefix' => 'cuenta', 'middleware' => 'auth:customer'], function () {
    Route::get('/perfil', function () {
        return view('customer.dashboard.index');
    })->name('customer.dashboard');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {})->middleware('setlocale');

Route::middleware('sitemap')->group(function () {
    Route::get('/es', 'App\Http\Controllers\Front\HomeController@index')->name('es.home');
    Route::get('/en', 'App\Http\Controllers\Front\HomeController@index')->name('en.home');
    Route::get('/es/juegos/{title}', 'App\Http\Controllers\Front\GameController@show')->name('es.game');
    Route::get('/en/games/{title}', 'App\Http\Controllers\Front\GameController@show')->name('en.game');
});

Route::post('/change-language', 'App\Http\Controllers\Front\LanguageController@changeLanguage')->name('change_language');

require __DIR__.'/auth.php';
require __DIR__.'/auth-customer.php';
