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
                'emails' => Email::latest()->get(),
                'favoriteCount' => Email::where('is_favorite', true)->count(),
                'sentCount' => Email::where('is_draft', false)->count()
            ];

            return view('home', $viewData);
        } catch (\Exception $e) {
            return view('home', [
                'emails' => collect([]),
                'favoriteCount' => 0,
                'sentCount' => 0,
                'error' => 'Could not load emails'
            ]);
        }
    }
}