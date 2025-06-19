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
            $userEmail = auth()->user()->email;

            $emails = Email::where(function ($query) use ($userEmail) {
                $query->where('from', $userEmail)
                    ->orWhere('to', $userEmail);
            })
                ->where('is_draft', false)
                ->latest()
                ->get();

            $viewData = [
                'email' => $emails,
                'favoriteCount' => Email::whereHas('favorites', function ($q) {
                    $q->where('user_id', auth()->id());
                })->count(),
                'sentCount' => Email::where('from', $userEmail)->where('is_draft', false)->count(),
                'draftCount' => Email::where('from', $userEmail)->where('is_draft', true)->count(),
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