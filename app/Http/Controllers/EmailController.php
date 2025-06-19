<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Favorite;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function show(Email $email)
    {
        $isFavorited = $email->favorites()->where('user_id', auth()->id())->exists();
        return view('email.show', compact('email', 'isFavorited'));
    }

    public function favorites()
    {
        $data = [
            'email' => Email::whereHas('favorites', function ($query) {
                $query->where('user_id', auth()->id());
            })->latest()->get(),
            'favoriteCount' => Favorite::where('user_id', auth()->id())->count(),
            'sentCount' => Email::where('from', auth()->user()->email)->count()
        ];

        return view('email.favorites', $data);
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

    public function create()
    {
        return view('email.create');
    }
    public function sent()
    {
        $email = Email::where('from', auth()->user()->email)
        ->where('is_draft', false)
        ->orderBy('created_at', 'descending')
        ->get();
        $favoriteCount = Email::where('is_favorite', true)->count();
        return view('home', compact('email', 'favoriteCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'to' => ['required', 'email', 'exists:users,email'],
            'subject' => 'required',
            'body' => 'required',
            'image' => 'nullable|image|max:2048' // max 2MB
        ],
        [
            'to.exists' => 'Alamat email tujuan tidak ada!'
        ]);

        if ($request->to === auth()->user()->email){
            return back()->withErrors('Tidak bisa mengirim email ke alamat sendiri!');
        }

        $filePath = null;
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('email-images', 'public');
        }

        $isDraft = $request->input('action') === 'draft';

        Email::create([
            'to' => $validated['to'],
            'from' => auth()->user()->email,
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'file_path' => $filePath,
            'is_draft' => $isDraft,
        ]);

        $message = $isDraft ? 'Draf berhasil tersimpan.' : 'Email berhasil terkirim.';

        return redirect()->route('home')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Email::destroy($id);
        return redirect()->back()->with("success", "Email berhasil dihapus");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Email::where('from', auth()->user()->email)->where('is_draft', false)->orderBy('created_at', 'desc')->get();

        return view('email.index', compact('emails'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function send(Request $request)
    {
        return $this->store($request);
    }

    public function apiIndex(Request $request)
    {
        $user = auth()->user();

        $query = Email::where('from', $user->id)->where('is_draft', false);

        // Optional: filter by subject if query param 'subject' diberikan
        if ($request->has('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        // Pagination 10 per halaman
        $email = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $email
        ]);
    }

    public function viewAll()
    {

        $user = auth()->user();
        $email = Email::where('from', $user->id)->get();
        return view('email.all', compact('email'));

    }

    public function getSentEmail()
    {
        $user = auth()->user();

        $sentEmail = Email::where('from', $user->id)
            ->where('is_draft', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $sentEmail
        ]);
    }

    public function update(Request $request, Email $email)
    {
        // Pastikan hanya bisa update draft, bukan email terkirim
        if ($email->is_draft === false || $email->from !== auth()->user()->email) {
            abort(403); // dilarang mengedit email yang sudah terkirim
        }

        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $email->update([
            'to' => $validated['to'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('drafts.index')->with('success', 'Draft updated successfully.');
    }

}