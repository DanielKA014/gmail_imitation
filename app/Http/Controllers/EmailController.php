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
    public function store(Request $request, $id = null, $isDraft = false)
    {
        $validated = $request->validate([
            "to"=>["required","exist:users,id"],
            "subject"=>["required","string"],
            "body"=>["required","string"],
            "file"=>["nullable","file","max:20480"], //max image 20mb
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('attachments', 'public');
        }

        $validated['from'] = auth()->id();
        $validated['is_draft'] = $request->action === $isDraft;

        if ($id) {
            Email::where('id', $id)->update($validated);
        } else {
            Email::create($validated);
        }

        Email::create($validated);

        return redirect()->route('email.index')->with('success', $isDraft ? 'Disimpan ke draft' : 'Email dikirim');
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


}
