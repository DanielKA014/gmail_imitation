<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return view('auth.login');
});
Route::resource('email', EmailController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/email/store', [EmailController::class, 'store'])->name('email.store');

Route::middleware('auth')->group(function () {
    Route::get('/api/emails/sent', [EmailController::class, 'getSentEmails']);
});

Route::middleware('auth')->get('/emails/all', [EmailController::class, 'viewAll']);

Route::post('/emails/send', [EmailController::class, 'send'])->name('emails.send');
