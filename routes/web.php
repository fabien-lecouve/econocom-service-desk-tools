<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageTranslationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLanguageSettingController;
use App\Http\Controllers\QuickMessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;



Route::get('/', function () {
    return redirect()->route('projects.index');
});


// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

// Login routes
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');


// Protected routes
Route::middleware('auth')->group(function () {

    Route::get('projects/{project}/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::get('projects/{project}/messages/create', [MessageController::class, 'create'])
        ->name('messages.create');

    Route::resource('categories', CategoryController::class)->except('create');

    Route::resource('messages', MessageController::class)->except('create');
    Route::resource('message-translations', MessageTranslationController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('project-language-settings', ProjectLanguageSettingController::class);

    Route::get('quick-messages/{project}', [QuickMessageController::class, 'index'])
        ->name('quick-messages.index');
});
