<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Email;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DraftController extends Controller
{
    //
    public function saveDraftEmail(Request $req)
    {
        $email = new Email();
        $email->to = $req->to;
        $email->subject = $req->subject;
        $email->body = $req->body;
        $email->is_draft = true;

        if ($req->hasFile('attachment')) {
            $filename = $req->file('attachment')->store('attachments');
            $email->attachment = $filename;
        }

        $email->save();

        return redirect()->back()->with('success', 'Email disimpan sebagai draf.');
    }

    public function send($id)
    {
        $email = Email::findOrFail($id);

        // Kirim email menggunakan Mail::raw atau Mail::send
        Mail::send([], [], function ($message) use ($email) {
            $message->to($email->to)
                    ->subject($email->subject)
                    ->setBody($email->body, 'text/html');

            if ($email->attachment) {
                $message->attach(Storage::path($email->attachment));
            }
        });

        // Tandai bahwa email ini bukan lagi draf
        $email->is_draft = false;
        $email->save();

        return redirect()->back()->with('success', 'Email berhasil dikirim.');
    }

    public function index()
    {
        $drafts = Email::where('is_draft', true)->get();
        return view('email.drafts', compact('drafts')); 
    }
}
