<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;

Route::get('/', function () {
    return view('auth.login');
});
Route::resource('email', App\Http\Controllers\EmailController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/email/draft', [DraftController::class, 'saveDraftEmail'])->name('email.draft');

Route::get('/email/send/{id}', [DraftController::class, 'send'])->name('email.send');