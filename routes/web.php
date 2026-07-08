<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageTranslationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectLanguageSettingController;
use App\Http\Controllers\QuickMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('projects/{project}/categories/create', [CategoryController::class, 'create'])
    ->name('categories.create');

Route::resource('categories', CategoryController::class)->except('create');

Route::resource('messages', MessageController::class);
Route::resource('message-translations', MessageTranslationController::class);
Route::resource('projects', ProjectController::class);
Route::resource('project-language-settings', ProjectLanguageSettingController::class);

Route::get('quick-messages/{project}', [QuickMessageController::class, 'index'])
    ->name('quick-messages.index');
