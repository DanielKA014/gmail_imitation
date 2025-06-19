<?php
namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    /**
     * Menampilkan semua email yang merupakan draf milik user saat ini.
     */
    public function index()
    {
        $drafts = Email::where('from', auth()->user()->email)->where('is_draft', true)->get();

        return view('email.drafts', compact('drafts'));
    }

    /**
     * Menyimpan email sebagai draf.
     */
    // DraftController.php
    public function store(Request $request)
    {
        $request->validate([
            'to' => 'nullable|email',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $email = new Email();
        $email->to = $request->to;
        $email->from = auth()->user()->email;
        $email->subject = $request->subject;
        $email->body = $request->body;
        $email->is_draft = true;

        if ($request->hasFile('attachment')) {
            $filename = $request->file('attachment')->store('attachments', 'public');
            $email->file_path = $filename;
        }

        $email->save();

        return redirect()->back()->with('success', 'Email disimpan sebagai draf.');
    }
}
