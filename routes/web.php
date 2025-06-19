<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteEmailController;

// Route to add an email to favorites
Route::post('/favorites/add', [FavoriteEmailController::class, 'addToFavorites'])->name('favorites.add');

// Route to view favorite emails
Route::get('/favorites', [FavoriteEmailController::class, 'getFavorites'])->name('favorites.index');
Route::get('/', function () {
    if (Auth::user()){
        return redirect()->route('home');
    }else{
        return view('auth.login');
    }
});
Route::resource('email', EmailController::class);

Auth::routes();

Route::post('/email/store', [EmailController::class, 'store'])->name('email.store');

Route::middleware('auth')->get('/emails/all', [EmailController::class, 'viewAll']);

Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/emails/favorites', [EmailController::class, 'favorites'])->name('emails.favorites');
    Route::get('/emails/create', [EmailController::class, 'create'])->name('emails.create');
    Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
    Route::post('/emails/{email}/favorite', [EmailController::class, 'toggleFavorite'])->name('emails.toggle-favorite');
    Route::get('/emails/{email}', [EmailController::class, 'show'])->name('emails.show');
    Route::get('/emails/sent', [EmailController::class, 'sent'])->name('emails.sent');
    Route::get('/emails/favorites', [EmailController::class, 'favorites'])->name('emails.favorites');
    Route::get('/emails/drafts', [DraftController::class, 'index'])->name('emails.drafts');
});

Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::middleware(['auth'])->get('user/delete', function () {
    return view('auth.delete');
})->name('user.delete.confirm');