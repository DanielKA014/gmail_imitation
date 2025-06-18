<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Favorite;
use Illuminate\Http\Request;

class EmailController extends Controller
{

    public function index()
    {
        $emails = Email::where('from', auth()->id())->where('is_draft', false)->get();
        $drafts = Email::where('from', auth()->id())->where('is_draft', true)->get();

        return view('email.index', compact('emails', 'drafts'));
    }
    /**
     * Store a newly created resource in storage.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Email::destroy($id);
        return redirect()->back()->with("success", "Email berhasil dihapus");
    }

    public function storeDraft(Request $request)
    {
        return $this->store($request);
    }

    public function send(Request $request, $id = null)
    {
        return $this->store($request);

    public function apiIndex(Request $request)
    {
        $user = auth()->user();

        $query = Email::where('from', $user->id)->where('is_draft', false);

        // Optional: filter by subject if query param 'subject' diberikan
        if ($request->has('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        // Pagination 10 per halaman
        $emails = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $emails
        ]);
    }

    public function viewAll()
    {
    
        $user = auth()->user();
        $emails = Email::where('from', $user->id)->get();
        return view('email.all', compact('emails'));

    }

    public function getSentEmails()
    {
        $user = auth()->user(); 

        $sentEmails = Email::where('from', $user->id)
                        ->where('is_draft', false)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $sentEmails
        ]);
    }
    public function show(Email $email)
    {
        $isFavorited = $email->favorites()->where('user_id', auth()->id())->exists();
        return view('emails.show', compact('email', 'isFavorited'));    }

    public function favorites()
    {
        $data = [
            'emails' => Email::whereHas('favorites', function($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get(),
            'favoriteCount' => Favorite::where('user_id', auth()->id())->count(),
            'sentCount' => Email::where('from', auth()->user()->email)->count()
        ];

        return view('emails.favorites', $data);
    }
    
    public function toggleFavorite(Email $email)
    {
        $favorite = Favorite::where([
            'email_id' => $email->id,
            'user_id' => auth()->id()
        ])->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $message = 'Email removed from favorites';
        } else {
            // Add to favorites
            Favorite::create([
                'email_id' => $email->id,
                'user_id' => auth()->id()
            ]);
            $message = 'Email added to favorites';
        }

        return back()->with('success', $message);
    }
    public function sent()
    {
        $emails = Email::where('from', auth()->user()->email)->get();
        $favoriteCount = Email::where('is_favorite', true)->count();
        return view('home', compact('emails', 'favoriteCount'));
    }

    public function drafts()
    {
        $emails = Email::where('is_draft', true)->get();
        $favoriteCount = Email::where('is_favorite', true)->count();
        return view('home', compact('emails', 'favoriteCount'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048' // max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('email-images', 'public');
        }

        Email::create([
            'to' => $validated['to'],
            'from' => auth()->user()->email,
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'image_path' => $imagePath
        ]);

        return redirect()->route('home')->with('success', 'Email sent successfully');
    }
}