<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageTranslationController;
use App\Http\Controllers\QuickMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class);
Route::resource('messages', MessageController::class);
Route::resource('message-translations', MessageTranslationController::class);

Route::get('quick-messages', [QuickMessageController::class, 'index'])->name('quick-messages.index');