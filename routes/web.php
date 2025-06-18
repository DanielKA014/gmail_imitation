<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});
Route::resource('email', EmailController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/email/store', [EmailController::class, 'store'])->name('email.store');

Route::middleware('auth')->get('/emails/all', [EmailController::class, 'viewAll']);

Route::middleware('auth')->group(function () {
    Route::get('/api/emails/sent', [EmailController::class, 'getSentEmails']);
});

Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::middleware('auth')->get('user/delete', function () {
    return view('auth.delete');
})->name('user.delete.confirm');