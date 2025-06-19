<?php

namespace App\Http\Controllers;

use App\Models\Email;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $viewData = [
                'email' => Email::latest()->get(),
                'favoriteCount' => Email::where('is_favorite', true)->count(),
                'sentCount' => Email::where('is_draft', false)->count(),
                'draftCount' => Email::where('is_draft', true)->count(),
            ];

            return view('home', $viewData);
        } catch (\Exception $e) {
            return view('home', [
                'email' => collect([]),
                'favoriteCount' => 0,
                'sentCount' => 0,
                'draftCount' => 0,
                'error' => 'Could not load emails'
            ]);
        }
    }
}