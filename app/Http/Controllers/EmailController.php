<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Email::where('from', auth()->id())->where('is_draft', false)->get();
        $drafts = Email::where('from', auth()->id())->where('is_draft', true)->get();

        return view('email.index', compact('emails', 'drafts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '<>', auth()->id())->get();
        return view("email.create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'to' => ['required', 'email'], // ← ini aku betulin: pisahkan required dan email
        'subject' => 'required',
        'body' => 'required',
        'image' => 'nullable|image|max:2048' // max 2MB
    ]);

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
        'is_draft' => $isDraft, // ← ini penting biar bisa simpan sebagai draft atau send
    ]);

    return redirect()->route('home')->with('success', $isDraft ? 'Email disimpan sebagai draf' : 'Email berhasil dikirim');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
        return redirect()->back()->with("success","Email berhasil dihapus");
    }

    public function storeDraft(Request $request)
    {
        return $this->store($request, true);
    }

    public function send(Request $request, $id = null)
    {
        return $this->store($request, false, $id);
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



}
