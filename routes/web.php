<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageTranslationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLanguageSettingController;
use App\Http\Controllers\QuickMessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

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

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.categories', CategoryController::class)->except('show');
    Route::resource('projects.messages', MessageController::class)->except('show');


    Route::resource('project-language-settings', ProjectLanguageSettingController::class)->only(['create', 'store']);


    // Route::resource('message-translations', MessageTranslationController::class); SI INUTILE, SUPPRIMER toute relation avec


    Route::get('quick-messages/{project}', [QuickMessageController::class, 'index'])
        ->name('quick-messages.index');

    Route::resource('users', UserController::class);
});
