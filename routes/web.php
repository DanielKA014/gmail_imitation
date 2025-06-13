<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/email/drafts', [DraftController::class, 'saveDraftEmail'])->name('email.drafts');

Route::get('/email/send/{id}', [DraftController::class, 'send'])->name('email.send');