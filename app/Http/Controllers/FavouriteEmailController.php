<?php

namespace App\Http\Controllers;

use App\Models\FavouriteEmail;
use Illuminate\Http\Request;

class FavouriteEmailController extends Controller
{
     /**
     * Add an email to favorites.
     */
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'email_id' => 'required|exists:emails,id',
        ]);

        $favoriteEmail = new FavoriteEmail();
        $favoriteEmail->user_id = auth()->id();
        $favoriteEmail->email_id = $request->email_id;
        $favoriteEmail->save();

        return redirect()->back()->with('success', 'Email added to favorites.');
    }

    /**
     * Retrieve the list of favorite emails.
     */
    public function getFavorites()
    {
        $favorites = FavoriteEmail::where('user_id', auth()->id())->with('email')->get();
        return view('email.favorites', compact('favorites'));
    }
}
