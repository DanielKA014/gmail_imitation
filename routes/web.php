<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteEmailController;

// Route to add an email to favorites
Route::post('/favorites/add', [FavoriteEmailController::class, 'addToFavorites'])->name('favorites.add');

// Route to view favorite email
Route::get('/favorites', [FavoriteEmailController::class, 'getFavorites'])->name('favorites.index');
Route::get('/', function () {
    if (Auth::user()){
        return redirect()->route('home');
    }else{
        return view('auth.login');
    }
});

Auth::routes();

Route::middleware('auth')->get('/email/all', [EmailController::class, 'viewAll']);

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/email/{email}/favorite', [EmailController::class, 'toggleFavorite'])->name('email.toggle-favorite');
    Route::get('/email/sent', [EmailController::class, 'sent'])->name('email.sent');
    Route::post('/email', [EmailController::class, 'store'])->name('email.store');
    Route::get('/email/favorites', [EmailController::class, 'favorites'])->name('email.favorites');
    Route::get('/email/drafts', [DraftController::class, 'index'])->name('email.drafts');
    Route::resource('email', EmailController::class);
});

Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::middleware(['auth'])->get('user/delete', function () {
    return view('auth.delete');
})->name('user.delete.confirm');